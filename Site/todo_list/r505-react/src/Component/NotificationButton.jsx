import { Badge, Button } from "@mui/material";
import MailIcon from "@mui/icons-material/Mail";
import { useDispatch, useSelector } from "react-redux";
import React, { useEffect, useState } from "react";
import { Toast } from "./Toast";
import {
  clearNotification,
  deleteNotification,
  hideAllNotifications,
  hideNotification,
} from "../store/slices/notification";
import DrawerNotifications from "./DrawerNotifications";

export default function NotificationButton() {
  let counter = useSelector(
    (state) => state.notificationReducer.notifications.length,
  );
  const notificationsList = useSelector(
    (state) => state.notificationReducer.notifications,
  );
  const [notifications, setNotifications] = useState([]);
  if (!counter) {
    counter = 0;
  }
  useEffect(() => {
    if (notificationsList.length > 0) {
      setNotifications(
        notificationsList.filter((notification) => notification.flag === true),
      );
    }
  }, [notificationsList]);

  const dispatch = useDispatch();
  const onHide = (id) =>
    dispatch(hideNotification({ type: "hideNotification", id }));
  const onDelete = (id) =>
    dispatch(deleteNotification({ type: "deleteNotification", id }));
  const onClear = () =>
    dispatch(clearNotification({ type: "clearNotification" }));

  const [open, setOpen] = React.useState(false);

  const toggleDrawer = (newOpen) => {
    setOpen(newOpen);
    dispatch(hideAllNotifications({ type: "hideAllNotifications" }));
  };
  return (
    <>
      <Button onClick={() => toggleDrawer(true)}>
        <Badge badgeContent={counter} color="primary">
          <MailIcon color="action" />
        </Badge>
      </Button>
      <DrawerNotifications
        notifications={notificationsList}
        onDelete={onDelete}
        open={open}
        toggleDrawer={toggleDrawer}
        onClear={onClear}
      />
      <Toast
        duration={2000}
        notifications={notifications}
        setNotifications={setNotifications}
        onHide={onHide}
        onDelete={onDelete}
      />
    </>
  );
}
