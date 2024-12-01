import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import AnimalItem from "../Molecule/AnimalItem";
import { fetchAnimalsSpecies } from "./FetchHook";
import NotFound from "./NotFound";
import Loading from "../Atomic/Loading";
import { getMe } from "../../api/zoo";
import SearchForm from "../Layout/SearchForm";

export default function AnimalsSpecies({ params }) {
  const [page, setAnimalsPagination] = useState(1);
  const [animalsData, setAnimalsData] = useState();
  const [userIsAdmin, setUserIsAdmin] = useState();
  useEffect(() => {
    setAnimalsData(null);
    fetchAnimalsSpecies(new URLSearchParams({ page }), params.id).then((json) =>
      setAnimalsData(json["hydra:member"]),
    );
    getMe().then((userMe) => {
      if (userMe != null) {
        setUserIsAdmin(userMe.roles.includes("ROLE_ADMIN"));
      }
    });
  }, []);
  if (animalsData === null) {
    return <Loading />;
  }
  if (!animalsData) {
    return <NotFound />;
  }
  return (
    <>
      <h1 className="text-center subpageTitle">
        Liste des animaux appartenant à l'espèce
      </h1>
      <hr />
      <SearchForm
        label="Rechercher"
        placeholder="Rechercher un animal parmis cette liste"
      />
      <ul
        className="container d-flex flex-wrap justify-content-center"
        style={{ listStyle: "none" }}
      >
        {animalsData.map((animal) => (
          <AnimalItem key={animal.id} data={animal} userIsAdmin={userIsAdmin} />
        ))}
      </ul>
    </>
  );
}
AnimalsSpecies.propTypes = {
  params: PropTypes.shape({
    id: PropTypes.string,
  }).isRequired,
};
