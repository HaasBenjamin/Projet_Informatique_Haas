import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import NotFound from "./NotFound";
import Loading from "../Atomic/Loading";
import CardItem from "../Molecule/CardItem.jsx";
import { fetchFamiliesCategory } from "./FetchHook.js";

export default function CategoryFamilies({ params }) {
  const [familiesData, setFamiliesData] = useState();

  useEffect(() => {
    setFamiliesData(null);
    fetchFamiliesCategory(params.id).then((json) => {
      setFamiliesData(json["hydra:member"]);
    });
  }, []);

  if (familiesData === null) {
    return <Loading />;
  }

  if (!familiesData) {
    return <NotFound />;
  }
  return (
    <>
      <h1 className="subpageTitle text-center">
        Liste des familles appartenant à la catégorie
      </h1>
      <hr />
      <ul
        className="container d-flex flex-wrap justify-content-center"
        style={{ listStyle: "none" }}
      >
        {familiesData.map((family) => (
          <CardItem key={family.id} data={family} type="Family" />
        ))}
      </ul>
    </>
  );
}
CategoryFamilies.propTypes = {
  params: PropTypes.shape({
    id: PropTypes.string,
  }).isRequired,
};
