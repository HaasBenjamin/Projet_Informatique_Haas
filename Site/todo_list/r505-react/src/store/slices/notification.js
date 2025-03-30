import { createSlice } from "@reduxjs/toolkit";

const initialState = {
  notifications: [],
  next: 1,
  authenticated: false,
};

const notificationSlice = createSlice({
  name: "notification",
  initialState,
  reducers: {
    createNotification: (state, action) => {
      state.notifications.push({
        id: state.next,
        content: action.payload.content,
        typeNotification: action.payload.typeNotification,
        flag: true,
      });
      state.next++;
    },
    hideNotification: (state, action) => {
      const index = state.notifications.findIndex(
        (notification) => notification.id === action.payload.id,
      );
      if (index !== -1) {
        state.notifications[index].flag = false;
      }
    },
    deleteNotification: (state, action) => {
      state.notifications = state.notifications.filter(
        (notification) => notification.id !== action.payload.id,
      );
    },
    isAuthenticated: (state, action) => {
      state.authenticated = action.payload.authenticated;
    },
    clearNotification: (state) => {
      state.notifications = [];
    },
    hideAllNotifications: (state) => {
      state.notifications = state.notifications.map((notification) => ({
        ...notification,
        flag: false,
      }));
    },
  },
});

export const {
  createNotification,
  hideNotification,
  hideAllNotifications,
  deleteNotification,
  clearNotification,
  isAuthenticated,
} = notificationSlice.actions;
export default notificationSlice.reducer;
