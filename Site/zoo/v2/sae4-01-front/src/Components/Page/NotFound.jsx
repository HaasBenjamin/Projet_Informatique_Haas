import React from "react";
import { Link } from "wouter";

export default function NotFound() {
  return (
    <>
      <video autoPlay muted loop id="myVideo">
        <source src="/img/videobackground.mp4" type="video/mp4" />
      </video>
      <h1 className="mainTitle">Erreur 404 : Pas de page pour cette URL</h1>
      <h2>
        <Link href="/">Retour sur la page d&apos;accueil</Link>
      </h2>
    </>
  );
}
