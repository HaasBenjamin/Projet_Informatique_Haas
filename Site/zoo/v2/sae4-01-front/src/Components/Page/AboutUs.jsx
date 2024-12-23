import React from "react";

export function AboutUs() {
  return (
    <>
      <link rel="stylesheet" href="/css/about_us.css" />
      <div className="map d-flex flex-column align-items-center">
        <img src="/img/map.png" useMap="#map" alt="Map" />

        <map name="map">
          <area
            shape="rect"
            coords="8,6,197,55"
            target="ours brun"
            href="http://localhost:5173/animals/1"
            alt="ours brun"
          />
          <area
            shape="rect"
            coords="199,6,401,56"
            target="ours polaire"
            href="http://localhost:5173/animals/2"
            alt="ours polaire"
          />
          <area
            shape="rect"
            coords="402,6,576,55"
            target="gorille"
            href="http://localhost:5173/animals/3"
            alt="gorille"
          />
          <area
            shape="rect"
            coords="9,56,94,202"
            target="chimpanzés"
            href="http://localhost:5173/animals/4"
            alt="chimpanzés"
          />
          <area
            shape="rect"
            coords="96,56,197,203"
            target="panda"
            href="http://localhost:5173/animals/5"
            alt="panda"
          />
          <area
            shape="rect"
            coords="199,58,306,203"
            target="tigre"
            href="http://localhost:5173/animals/6"
            alt="tigre"
          />
          <area
            shape="rect"
            coords="309,58,401,202"
            target="lion"
            href="http://localhost:5173/animals/7"
            alt="lion"
          />
          <area
            shape="rect"
            coords="403,57,460,203"
            target="girafe"
            href="http://localhost:5173/animals/9"
            alt="girafe"
          />
          <area
            shape="rect"
            coords="461,57,504,202"
            target="chouette"
            href="http://localhost:5173/animals/14"
            alt="chouette"
          />
          <area
            shape="rect"
            coords="505,57,578,199"
            target="panthère noire"
            href="http://localhost:5173/animals/8"
            alt="panthère noire"
          />
          <area
            shape="rect"
            coords="10,204,147,308"
            target="rhinocéros"
            href="http://localhost:5173/animals/10"
            alt="rhinocéros"
          />
          <area
            shape="rect"
            coords="149,205,196,307"
            target="lémur"
            href="http://localhost:5173/animals/16"
            alt="lémur"
          />
          <area
            shape="rect"
            coords="10,309,76,392"
            target="aigle"
            href="http://localhost:5173/animals/12"
            alt="aigle"
          />
          <area
            shape="rect"
            coords="78,309,197,397"
            target="hippoppotames"
            href="http://localhost:5173/animals/11"
            alt="hippoppotames"
          />
          <area
            shape="rect"
            coords="199,205,263,397"
            target="loup"
            href="http://localhost:5173/animals/17"
            alt="loup"
          />
          <area
            shape="rect"
            coords="264,204,388,397"
            target="éléphant"
            href="http://localhost:5173/animals/15"
            alt="éléphant"
          />
          <area
            shape="rect"
            coords="460,203,502,397"
            target="vautour"
            href="http://localhost:5173/animals/18"
            alt="vautour"
          />
          <area
            shape="rect"
            coords="388,205,460,396"
            target="crocodile"
            href="http://localhost:5173/animals/19"
            alt="crocodile"
          />
          <area
            shape="rect"
            coords="505,202,592,341"
            target="antilope"
            href="http://localhost:5173/animals/13"
            alt="antilope"
          />
          <area
            shape="rect"
            coords="505,343,591,396"
            target="iguane"
            href="http://localhost:5173/animals/20"
            alt="iguane"
          />
        </map>
      </div>
      <footer className="d-flex align-items-center justify-content-center gap-5">
        <img src="/img/logo.png" alt="Logo" width="120" height="120" />
        <span>Contacts :</span>
        <ul>
          <li>Gouedar Pierre - pierre.gouedar@etudiant.univ-reims.fr</li>
          <li>Haas Benjamin - benjamin.haas@etudiant.univ-reims.fr</li>
          <li>Lawson Marc-Aurel - marc-aurel.lawson@etudiant.univ-reims.fr</li>
          <li>Le Gros Antoine - antoine.le-gros@etudiant.univ-reims.fr</li>
          <li>Titeux Gabriel - gabriel.titeux@etudiant.univ-reims.fr</li>
        </ul>
      </footer>
    </>
  );
}

export default AboutUs;
