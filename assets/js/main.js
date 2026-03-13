document.addEventListener("DOMContentLoaded", function () {
  if (typeof themeData !== "undefined") {
    window.ajaxUrl = themeData.ajaxUrl;
    window.nonce = themeData.nonce;
  }
});
