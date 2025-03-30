import PropTypes from "prop-types";
import { useEffect, useState } from "react";

export default async function useServiceWorker(
  path,
  onNotification,
  onAuthentication,
  onDisconnect,
) {
  const [isServiceWorker, setIsServiceWorker] = useState(false);
  useEffect(() => {
    if ("serviceWorker" in navigator && !isServiceWorker) {
      try {
        const registration = navigator.serviceWorker
          .register(path, {
            scope: "/",
          })
          .then(() => {
            navigator.serviceWorker.addEventListener("message", (event) => {
              if (event.data.type === "notification") {
                onNotification(event.data.msg);
              } else if (event.data.type === "authentication") {
                onAuthentication();
              } else if (event.data.type === "disconnect") {
                onDisconnect();
              }
            });
            if (registration.installing) {
              onNotification("Service worker installing");
            } else if (registration.waiting) {
              onNotification("Service worker installed");
            } else if (registration.active) {
              onNotification("Service worker active");
              setIsServiceWorker(true);
            }
          });
      } catch (error) {
        setIsServiceWorker(false);
        onNotification(`Registration failed with ${error}`);
      }
    }
  }, []);

  return { isServiceWorker };
}
useServiceWorker.propTypes = {
  path: PropTypes.string,
  onNotification: PropTypes.func.isRequired,
  onAuthentication: PropTypes.func.isRequired,
  onDisconnect: PropTypes.func.isRequired,
};
