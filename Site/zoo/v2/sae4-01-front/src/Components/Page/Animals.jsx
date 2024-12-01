import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import { fetchAllAnimals } from "./FetchHook";
import AnimalItem from "../Molecule/AnimalItem";
import Loading from "../Atomic/Loading";
import SearchForm from "../Layout/SearchForm";
import { getMe } from "../../api/zoo";

export default function Animals({ search = "" }) {
  const [page] = useState(1);
  const [animalsData, setAnimalsData] = useState();
  const [userIsAdmin, setUserIsAdmin] = useState();
  useEffect(() => {
    setAnimalsData(null);
    fetchAllAnimals(new URLSearchParams({ page })).then((json) => {
      setAnimalsData(json["hydra:member"]);
    });
    getMe().then((userMe) => {
      if (userMe != null) {
        setUserIsAdmin(userMe.roles.includes("ROLE_ADMIN"));
      }
    });
  }, []);
  console.log(animalsData);
  return (
    <>
      <link rel="stylesheet" href="/css/animals.css" />
      <h1 className="text-center subpageTitle">Liste des animaux </h1>
      <hr />
      <SearchForm
        placeholder="Rechercher un animal parmis notre liste"
        label="Rechercher"
      />
      {!animalsData ? (
        <Loading />
      ) : (
        <ul
          className="container d-flex flex-wrap justify-content-center"
          style={{ listStyle: "none" }}
        >
          {animalsData.map((animal) => (
            <AnimalItem
              key={animal.id}
              data={animal}
              userIsAdmin={userIsAdmin}
            />
          ))}
        </ul>
      )}
    </>
  );
}

Animals.propTypes = {
  search: PropTypes.string,
};
