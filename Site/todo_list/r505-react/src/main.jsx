import "@fontsource/roboto/300.css";
import "@fontsource/roboto/400.css";
import "@fontsource/roboto/500.css";
import "@fontsource/roboto/700.css";
import { createRoot } from "react-dom/client";
import { Provider } from "react-redux";
import App from "./App";
import storeNotification from "./store";

createRoot(document.getElementById("root")).render(
  <Provider store={storeNotification}>
    <App />
  </Provider>,
);
