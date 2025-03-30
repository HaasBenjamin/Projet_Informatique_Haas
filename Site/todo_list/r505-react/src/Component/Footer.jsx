import React, { useContext } from "react";
import Icon from "@mui/material/Icon";
import { Box, Button } from "@mui/material";
import { themeContext } from "../context/Theme/index";
import NotificationButton from "./NotificationButton";

function Footer() {
  const { theme, themeStatus, switchTheme } = useContext(themeContext);
  return (
    <Box className="footer">
      <Button
        onClick={() => {
          switchTheme();
        }}
      >
        <Icon>contrast</Icon>
      </Button>
      <NotificationButton />
    </Box>
  );
}

export default Footer;
