import React, { useContext, useEffect, useState } from "react";
import { useLocation } from "wouter";
import PropTypes from "prop-types";
import { deleteAnimal, getAnimalById } from "./FetchHook";
import Loading from "../Atomic/Loading";
import { CurrentUserContext } from "../../Contexts/User/User";

export default function AnimalDelete({ animalId }) {
  const user = useContext(CurrentUserContext);
  const [, setLocation] = useLocation();
  if (!user?.roles?.includes("ROLE_ADMIN")) {
    setLocation("/animals");
  }
  const [animalName, setAnimalName] = useState();
  useEffect(() => {
    getAnimalById(`/${animalId}`).then((response) => {
      setAnimalName(response.name);
    });
  }, []);
  const handleCancel = (event) => {
    event.preventDefault();
    setLocation("/animals");
  };
  const handleSubmit = (event) => {
    event.preventDefault();
    deleteAnimal(animalId);
    setLocation("/animals");
  };
  return (
    // eslint-disable-next-line react/jsx-no-useless-fragment
    <>
      {animalName ? (
        <>
          <h1 className="m-5" style={{ color: "white" }}>
            Suppression de {animalName}
          </h1>
          <div className="alert alert-danger w-100 m-5" role="alert">
            {/* eslint-disable-next-line react/no-unescaped-entities */}
            Voulez-vous vraiment supprimer l'animal {animalName} ?
          </div>
          <form
            name="form"
            method="post"
            className=" d-flex m-5 justify-content-around"
          >
            <div className="mb-3">
              <button
                type="submit"
                id="form_cancel"
                name="form[cancel]"
                className="btn btn-secondary btn"
                onClick={handleCancel}
              >
                Annuler
              </button>
            </div>
            <div className="mb-3">
              <button
                type="submit"
                id="form_delete"
                name="form[delete]"
                className="btn btn-primary btn"
                onClick={handleSubmit}
              >
                Supprimer
              </button>
            </div>
          </form>
        </>
      ) : (
        <Loading />
      )}
    </>
  );
}

AnimalDelete.propTypes = {
  animalId: PropTypes.string.isRequired,
};
