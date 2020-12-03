let themeValue = 0;

function toggleElement(element) {
  let x = document.querySelector(element);
  if (x.style.display == "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function getTheme() {
  if (getCookie("themeValue") == "0") {
    document.querySelector(".navbar").style.backgroundColor = "";
    document.body.style.backgroundColor = "";
    for (let i = 0; i < document.querySelectorAll("div").length; i++) {
      document.querySelectorAll("div")[i].style.backgroundColor = "";
    }
    for (
      let i = 0;
      i <
      document.querySelectorAll(
        "h1, h2, h3, h4, h5, h6, p, label, .tweet-innerhtml"
      ).length;
      i++
    ) {
      document.querySelectorAll(
        "h1, h2, h3, h4, h5, h6, p, label, .tweet-innerhtml"
      )[i].style.color = "";
    }
    themeValue = 0;
  } else if (getCookie("themeValue") == "1") {
    document.body.style.backgroundColor = "black";
    for (let i = 0; i < document.querySelectorAll("div").length; i++) {
      document.querySelectorAll("div")[i].style.backgroundColor = "black";
    }
    for (
      let i = 0;
      i <
      document.querySelectorAll(
        "h1, h2, h3, h4, h5, h6, p, label, .tweet-innerhtml"
      ).length;
      i++
    ) {
      document.querySelectorAll(
        "h1, h2, h3, h4, h5, h6, p, label, .tweet-innerhtml"
      )[i].style.color = "white";
    }
    themeValue = 1;
  }
}

function switchTheme() {
  if (themeValue == 0) {
    document.cookie = "themeValue=1";
    document.body.style.backgroundColor = "black";
    for (let i = 0; i < document.querySelectorAll("div").length; i++) {
      document.querySelectorAll("div")[i].style.backgroundColor = "black";
    }
    for (
      let i = 0;
      i <
      document.querySelectorAll(
        "h1, h2, h3, h4, h5, h6, p, label, .tweet-innerhtml"
      ).length;
      i++
    ) {
      document.querySelectorAll(
        "h1, h2, h3, h4, h5, h6, p, label, .tweet-innerhtml"
      )[i].style.color = "white";
    }
    themeValue = 1;
  } else if (themeValue == 1) {
    document.cookie = "themeValue=0";
    document.querySelector(".navbar").style.backgroundColor = "";
    document.body.style.backgroundColor = "";
    for (let i = 0; i < document.querySelectorAll("div").length; i++) {
      document.querySelectorAll("div")[i].style.backgroundColor = "";
    }
    for (
      let i = 0;
      i <
      document.querySelectorAll(
        "h1, h2, h3, h4, h5, h6, p, label, .tweet-innerhtml"
      ).length;
      i++
    ) {
      document.querySelectorAll(
        "h1, h2, h3, h4, h5, h6, p, label, .tweet-innerhtml"
      )[i].style.color = "";
    }
    themeValue = 0;
  }
}

function hashtag(text) {
  var repl = text.replace(
    /#(\w+)/g,
    '<a href="tweetQuery.php?search=%23$1">#$1</a>'
  );
  return repl;
}

function arobase(text) {
  var repl = text.replace(/@(\w+)/g, '<a href="profil.php?id=%40$1">@$1</a>');
  return repl;
}

window.onload = function() {
  getTheme();

  for (
    let i = 0;
    i < document.querySelectorAll(".tweet-innerhtml").length;
    i++
  ) {
    document.querySelectorAll(".tweet-innerhtml")[i].innerHTML = hashtag(
      document.querySelectorAll(".tweet-innerhtml")[i].innerHTML
    );
  }

  for (let i = 0; i < document.querySelectorAll(".div-users").length; i++) {
    document.querySelectorAll(".div-users")[i].innerHTML = arobase(
      document.querySelectorAll(".div-users")[i].innerHTML.slice(0, -2)
    );
  }

  for (let i = 0; i < document.querySelectorAll(".tweet").length; i++) {
    document.querySelectorAll(".tweet")[i].innerHTML = arobase(
      document.querySelectorAll(".tweet")[i].innerHTML
    );
  }
};
