import { configureStore } from "@reduxjs/toolkit";
import notificationReducer from "./slices/notification";
import { taskApi } from "../services/task";

const storeNotification = configureStore({
  reducer: {
    notificationReducer,
    [taskApi.reducerPath]: taskApi.reducer,
  },
  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware().concat(taskApi.middleware),
});

export default storeNotification;
