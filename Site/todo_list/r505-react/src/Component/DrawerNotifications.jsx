import * as React from "react";
import Box from "@mui/material/Box";
import Drawer from "@mui/material/Drawer";
import List from "@mui/material/List";
import { Alert, Button, Divider } from "@mui/material";
import { useEffect, useState } from "react";

export default function DrawerNotifications({
  notifications,
  onDelete,
  open,
  toggleDrawer,
  onClear,
}) {
  const handleClose = (id) => {
    onDelete(id);
  };

  const clearAll = () => {
    onClear();
    toggleDrawer(false);
  };

  const [drawerList, setDrawerList] = useState("");

  useEffect(() => {
    setDrawerList(
      notifications.map((notification) => (
        <div key={notification.id}>
          <Alert
            className="mb-1"
            onClick={() => handleClose(notification.id)}
            severity={notification.typeNotification}
            variant="filled"
            sx={{ width: "100%" }}
          >
            {notification.content}
          </Alert>
          <Divider />
        </div>
      )),
    );
  }, [notifications, open]);
  const clearButton = (
    <Button onClick={() => clearAll()}>Tout Supprimer</Button>
  );

  return (
    <Drawer
      open={open}
      onClose={() => toggleDrawer(false)}
      anchor="right"
      className="d-flex flex-column flex-grow-1"
    >
      <Box
        sx={{ width: 250 }}
        role="presentation"
        className="d-flex flex-column flex-grow-1"
      >
        <List className="justify-content-between d-flex flex-column flex-grow-1">
          <div>{drawerList}</div>
          {notifications.length > 0 ? clearButton : ""}
        </List>
      </Box>
    </Drawer>
  );
}
