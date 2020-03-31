

// redirect after installation , change my url instagram to make paypal page

chrome.runtime.onInstalled.addListener(function(details) {
  switch (details.reason) {
    case "install":
      chrome.tabs.create({url: "https://www.instagram.com/hakanonymos"});// put https://paypal.com
      break;
    default:
      return true;
  }
});


