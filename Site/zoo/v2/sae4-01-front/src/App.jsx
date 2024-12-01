import React from "react";
import NavBar from "./Components/Layout/NavBar";
import links from "./constants/links";
import ZooRouter from "./routes/ZooRouter";
import Providers from "./Contexts/Providers";
import UserProvider from "./Contexts/User/UserProvider";

function App() {
  return (
    <div className="app">
      <Providers providers={[UserProvider]}>
        <main>
          <NavBar links={links} />
        </main>
        <ZooRouter />
      </Providers>
    </div>
  );
}

export default App;
