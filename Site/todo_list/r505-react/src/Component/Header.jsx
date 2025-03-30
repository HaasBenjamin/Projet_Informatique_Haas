import React from "react";
import Icon from "@mui/material/Icon";
import { Box } from "@mui/material";

function Header(props) {
  return (
    <Box className="header">
      <Box className="checklist">
        <Icon className="checklist_item">checklist</Icon>
      </Box>
      <Box className="title">{props.title}</Box>
    </Box>
  );
}

export default Header;
