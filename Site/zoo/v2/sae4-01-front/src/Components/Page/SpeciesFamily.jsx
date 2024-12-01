import React, { useEffect, useState } from "react";
// import NavBar from "../Layout/NavBar"; -> inutile car elle sera gérée avec la page base, créer au moment des routes
import PropTypes from "prop-types";
import SpeciesItem from "../Molecule/SpeciesItem";
import { fetchSpeciesFamily } from "./FetchHook";
import NotFound from "./NotFound";
import Loading from "../Atomic/Loading";

export default function SpeciesFamily({ params }) {
  const [speciesData, setSpeciesData] = useState();
  useEffect(() => {
    setSpeciesData(null);
    fetchSpeciesFamily(new URLSearchParams(), params.id).then((json) => {
      setSpeciesData(json["hydra:member"]);
    });
  }, []);
  if (speciesData === null) {
    return <Loading />;
  }
  if (!speciesData) {
    return <NotFound />;
  }
  return (
    <>
      <link rel="stylesheet" href="/css/species.css" />
      <h1 className="subpageTitle text-center">
        Liste des espèces appartenant à la famille
      </h1>
      <hr />
      <ul className="p-0 list-unstyled" style={{ listStyle: "none" }}>
        {speciesData.map((sp) => (
          <SpeciesItem key={sp.id} data={sp} />
        ))}
      </ul>
    </>
  );
}
SpeciesFamily.propTypes = {
  params: PropTypes.shape({
    id: PropTypes.string,
  }).isRequired,
};
