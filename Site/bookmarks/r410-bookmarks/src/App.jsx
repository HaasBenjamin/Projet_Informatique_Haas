import React, { useContext, useState } from "react";
import RouteSwitch from "./routes/index";
import Section from "./contexts/user/Provider";
import Header from "./components/Header";
import { TitleContext } from "./contexts/title/index";
import Footer from "./components/Footer";

function App() {
  const [page, setPage] = useState(1);
  const color = useContext(TitleContext());
  return (
    <div className="app">
      <header className="app__header header">
        <Header color={color.color} />
        <h1 className="header__title">Introduction to React</h1>
      </header>
      <main className="app__main">
        <Section />
        <RouteSwitch page={page} setPage={setPage} />
      </main>
      <Footer className="app__footer footer" setColor={color.setColor} />
    </div>
  );
}

export default App;
