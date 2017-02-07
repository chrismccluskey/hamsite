document.addEventListener('DOMContentLoaded', function () {
  var i = 0;
  //The download as png doesn't work on WebKit
  var isWebkit = 'WebkitAppearance' in document.documentElement.style;
  //Prepare mermaid
  mermaid.initialize({
    flowchart: {
      useMaxWidth: false
    }});
  //Parse every hook
  [].forEach.call(document.querySelectorAll('.mermaid-noise'), function (el) {
    i++;
    //Get the markdown text
    var convert = el.innerHTML;
    convert = convert.replace(/\[n\]/g, "\n");
    //Get the hook name
    var hook = convert.slice(15).split(']');
    hook = hook[0];
    
    document.querySelector('.body').innerHTML += "<h3 id='" + hook + "'>Hook " + hook + "</h3>";
    document.querySelector('.buttons').innerHTML += "<a href='#" + hook + "' class='button'>" + hook + "</a><input type='checkbox' data-hook='" + hook + "' data-id='" + i + "' alt='Hide' title='Hide' class='hide-hook' style='margin-top:3px'/>";
    if (!isWebkit) {
      document.querySelector('.body').innerHTML += "<button class='button button-primary mermaid-download' data-id='" + i + "'>Download</button>";
    }
    document.querySelector('.body').innerHTML += "<div class='mermaid-" + i + "'>" + convert + "</div><hr data-id='" + i + "'>";
    //Generate the flowchart
    mermaid.init(".mermaid-" + i);
  });
  //Go to top
  document.querySelector('button.gotop').addEventListener('click', function () {
    document.body.scrollTop = document.documentElement.scrollTop = 0;
  });
  //Hide system for hooks
  [].forEach.call(document.querySelectorAll('.hide-hook'), function (e) {
    e.addEventListener('click', function () {
      if (e.checked) {
        document.querySelector(".mermaid-" + e.dataset.id).style.display = 'none';
        document.querySelector("#" + e.dataset.hook).style.display = 'none';
        document.querySelector(".mermaid-download[data-id='" + e.dataset.id + "']").style.display = 'none';
        document.querySelector("hr[data-id='" + e.dataset.id + "']").style.display = 'none';
      } else {
        document.querySelector(".mermaid-" + e.dataset.id).style.display = 'block';
        document.querySelector("#" + e.dataset.hook).style.display = 'block';
        document.querySelector("hr[data-id='" + e.dataset.id + "']").style.display = 'block';
      }
    });
  });
  //Download system
  if (!isWebkit) {
    [].forEach.call(document.querySelectorAll('button.mermaid-download'), function (e) {
      e.addEventListener('click', function () {
        svgToPng(document.querySelector(".mermaid-" + e.dataset.id + ' svg'));
      });
    });

    function svgToPng(source) {
      //Prepare the canvas
      var canvas = document.createElement("canvas");
      canvas.setAttribute('width', source.getBBox().width);
      canvas.setAttribute('height', source.getBBox().height);
      var ctx = canvas.getContext("2d");
      //Prepare the image
      var img = new Image();
      //this doesn't work but maybe enalbe the support for webkit
      img.setAttribute('crossOrigin', 'anonymous');
      img.crossOrigin = "Anonymous";
      //Get the hook name 
      var name = source.querySelector('#a div').innerHTML;
      var svgString = new XMLSerializer().serializeToString(source);
      //Hack for Mermaid to replace div to text object
      svgString = svgString.replace(/div/g, "text");
      //Convert the svg string in a blob
      var svg = new Blob([svgString], {
        type: "image/svg+xml;charset=utf-8"
      });
      //Convert as an URL
      var url = window.URL.createObjectURL(svg);
      img.onload = function () {
        ctx.drawImage(img, 0, 0);
        var png = canvas.toDataURL("image/png");
        //Generate a img tag
        var target = document.createElement('img');
        target.className = "on-the-fly";
        //We pass the empty canvas
        target.src = png;
        document.body.appendChild(target);
        window.URL.revokeObjectURL(png);
      };
      //Add the URL in the img
      img.src = url;
      //Little timeout to get the image
      var timeout = window.setTimeout(function () {
        var a = document.createElement('a');
        a.download = name + '.png';
        a.href = document.querySelector('.on-the-fly').src;
        document.body.appendChild(a);
        a.addEventListener("click", function () {
          //Cleaning
          a.parentNode.removeChild(a);
          document.querySelector('.on-the-fly').parentNode.removeChild(document.querySelector('.on-the-fly'));
        });
        a.click();
        window.clearTimeout(timeout);
      }, 200);
    }
  }

});
