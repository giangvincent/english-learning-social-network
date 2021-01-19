import helperFunc from "./helperFunc";

function initSW() {
  if (!"serviceWorker" in navigator) {
    console.log("service worker isn't supported");
    //service worker isn't supported
    return;
  }

  //don't use it here if you use service worker
  //for other stuff.
  if (!"PushManager" in window) {
    //push isn't supported
    console.log("push isn't supported");
    return;
  }

  //register the service worker
  navigator.serviceWorker
    .register("/sw.js")
    .then(() => {
      console.log("serviceWorker installed!");
      initPush();
    })
    .catch(err => {
      console.log(err);
    });
}

function initPush() {
  if (!navigator.serviceWorker.ready) {
    return;
  }

  new Promise(function(resolve, reject) {
    const permissionResult = Notification.requestPermission(function(result) {
      resolve(result);
    });

    if (permissionResult) {
      permissionResult.then(resolve, reject);
    }
  }).then(permissionResult => {
    if (permissionResult !== "granted") {
      throw new Error("We weren't granted permission.");
    }
    subscribeUser();
  });
}

function subscribeUser() {
  navigator.serviceWorker.ready
    .then(registration => {
      const subscribeOptions = {
        userVisibleOnly: true,
        applicationServerKey: helperFunc.urlBase64ToUint8Array(
          "BKIjZB1EdkwMo6ek1izI1mLeAQ6dPgqJdo3Xh7k99RUoMIGqZRfIWUn8phcqH3jufSELAYrV2LnySZnAeCVmFxA"
        )
      };

      return registration.pushManager.subscribe(subscribeOptions);
    })
    .then(pushSubscription => {
      console.log(
        "Received PushSubscription: ",
        JSON.stringify(pushSubscription)
      );
      storePushSubscription(pushSubscription);
    });
}

function storePushSubscription(pushSubscription) {
  fetch("/push", {
    method: "POST",
    body: JSON.stringify(pushSubscription),
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
      "X-CSRF-Token": token
    }
  })
    .then(res => {
      return res.json();
    })
    .then(res => {
      console.log(res);
    })
    .catch(err => {
      console.log(err);
    });
}
export default { initSW };
