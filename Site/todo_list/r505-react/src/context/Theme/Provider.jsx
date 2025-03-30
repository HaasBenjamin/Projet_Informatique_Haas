import {Box, ThemeProvider, useMediaQuery} from "@mui/material";
import {themeContext} from "./index.jsx";
import {useState} from "react";
import {themeDark, themeLight} from "../../assets/themes/ListTheme.jsx";

export function ProviderTheme({children}) {
    const prefersDarkMode = useMediaQuery('(prefers-color-scheme: dark)');
    const [theme,setTheme] = useState(prefersDarkMode ? themeDark : themeLight);
    const [themeStatus, setThemeStatus] = useState(prefersDarkMode ? 'dark' :'light')
    const switchTheme = () => {
        setTheme(themeStatus === 'light' ? themeDark : themeLight);
        setThemeStatus(themeStatus === 'light'? 'dark' : 'light')
    }
    const themeObject = {
        theme,
        themeStatus,
        switchTheme
    };
    return (
        <themeContext.Provider value={themeObject}>
            <ThemeProvider theme={theme}>
                <Box className="app">
                    {children}
                </Box>
            </ThemeProvider>
        </themeContext.Provider>
    );
}