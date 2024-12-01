import React, { useEffect, useState } from "react";
import { fetchAllSpecies } from "./FetchHook";
import SpeciesItem from "../Molecule/SpeciesItem";
import Loading from "../Atomic/Loading";

export function Species() {
  const [speciesData, setSpeciesData] = useState([]);
  useEffect(() => {
    fetchAllSpecies(new URLSearchParams()).then((json) => {
      setSpeciesData(json["hydra:member"]);
    });
  }, []);
  return (
    <>
      <link rel="stylesheet" href="/css/species.css" />
      <h1 className="subpageTitle text-center">Liste des espèces </h1>
      <hr />
      <ul className="p-0 list-unstyled">
        {speciesData === null
          ? Loading()
          : speciesData.map((sp) => <SpeciesItem key={sp.id} data={sp} />)}
      </ul>
    </>
  );
}

export default Species;
