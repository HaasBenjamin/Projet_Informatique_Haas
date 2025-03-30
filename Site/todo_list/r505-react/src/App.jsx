import React from "react";
import { Box, CssBaseline } from "@mui/material";
import Header from "./Component/Header";
import Main from "./Component/Main";
import Footer from "./Component/Footer";
import "./index.css";
import { ProviderTheme } from "./context/Theme/Provider";

function App() {
  return (
    <ProviderTheme>
      <CssBaseline />
      <Box className="app">
        <Header title="TaskList Manager !" />
        <Main />
        <Footer />
      </Box>
    </ProviderTheme>
  );
}

export default App;
