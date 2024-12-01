import React from "react";
import SearchForm from "../Layout/SearchForm";

export default function Index() {
  return (
    <>
      <video autoPlay muted loop id="myVideo">
        <source src="/img/videobackground.mp4" type="video/mp4" />
      </video>
      <h1 className="mainTitle">Bienvenue chez ZooTech Park</h1>
      <hr />
      <h2>Vous souhaitez chercher un animal parmis notre zoo ?</h2>
      <SearchForm placeholder="Rechercher un animal" label="Rechercher" />
    </>
  );
}
