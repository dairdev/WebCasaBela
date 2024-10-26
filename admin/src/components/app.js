import { h } from "preact";
import { Router } from "preact-router";
import { ThemeProvider, createTheme } from "@mui/material/styles";
import CssBaseline from "@mui/material/CssBaseline";

import Header from "./header";

const darkTheme = createTheme({
  palette: {
    mode: "light",
  },
});

// Code-splitting is automated for `routes` directory
import Home from "../routes/home";
import PropertyRoute from "../routes/property";

const App = () => (
  <ThemeProvider theme={darkTheme}>
    <div id="app">
      <CssBaseline />
      <Header />
      <main>
        <Router>
          <Home path="/" />
          <PropertyRoute path="/property" />
        </Router>
      </main>
    </div>
  </ThemeProvider>
);

export default App;
