import React, { useEffect, useState } from "react";
// import NavBar from "../Layout/NavBar";
// eslint-disable-next-line no-unused-vars
import PropTypes from "prop-types";
import { fetchEnclosureAnimals } from "./FetchHook";
import AnimalItem from "../Molecule/AnimalItem";

export default function EnclosureAnimals({ params }) {
  const [animalsData, setAnimalsData] = useState();
  useEffect(() => {
    setAnimalsData(null);
    fetchEnclosureAnimals(new URLSearchParams(), params.enclosureId).then(
      (json) => {
        setAnimalsData(json["hydra:member"]);
      },
    );
  }, []);
  return (
    <>
      {!animalsData ? (
        <p>Loading</p>
      ) : (
        <ul
          className="container d-flex flex-wrap justify-content-center"
          style={{ listStyle: "none" }}
        >
          {animalsData.map((animal) => (
            <AnimalItem key={animal.id} data={animal} />
          ))}
        </ul>
      )}
    </>
  );
}

EnclosureAnimals.propTypes = {
  params: PropTypes.objectOf(
    PropTypes.shape({
      enclosureId: PropTypes.number,
    }),
  ).isRequired,
};
