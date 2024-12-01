import React, { useContext, useEffect, useState } from "react";
import { useLocation } from "wouter";
import PropTypes from "prop-types";
import {
  fetchAllEnclosures,
  fetchAllSpecies,
  getAnimalById,
  patchAnimal,
  DeleteImage,
  postImage,
  streamToString,
} from "./FetchHook";
import Loading from "../Atomic/Loading";
import "../../../public/css/form.css";
import AnimalForm from "../Molecule/AnimalForm";
import { CurrentUserContext } from "../../Contexts/User/User";

export default function AnimalUpdate({ animalId }) {
  const [animalData, setAnimalData] = useState();
  const [speciesData, setSpeciesData] = useState();
  const [enclosuresData, setEnclosuresData] = useState();
  const user = useContext(CurrentUserContext);
  const [, setLocation] = useLocation();
  if (!user?.roles?.includes("ROLE_ADMIN")) {
    setLocation("/animals");
  }

  useEffect(() => {
    getAnimalById(`/${animalId}`).then((json) => {
      setAnimalData(json);
    });
    fetchAllSpecies().then((json) => {
      setSpeciesData(json["hydra:member"]);
    });
    fetchAllEnclosures().then((json) => {
      setEnclosuresData(json["hydra:member"]); // Correction ici
    });
  }, []);
  const handleSubmit = async (event) => {
    event.preventDefault();
    const image = event.target[4].files[0];
    let data = {
      id: animalId,
      name: event.target[0].value,
      description: event.target[1].value,
      species: `/api/species/${event.target[2].value}`,
      enclosure: `/api/enclosures/${event.target[3].value}`,
    };
    if (image) {
      postImage(image).then((response) => {
        streamToString(response.body)
          .then((bodyString) => {
            data = {
              ...data,
              image: `/api/images/${bodyString}`,
            };
            patchAnimal(data).then(() => {
              if (animalData?.image) {
                DeleteImage(animalData.image.split("/").pop());
              }
              setLocation(`/animals/${animalId}`);
            });
          })
          .catch((error) => {
            console.error(
              "Une erreur s'est produite lors de la lecture du corps de la réponse :",
              error,
            );
          });
      });
    } else {
      patchAnimal(data);
    }
    await patchAnimal(data);
  };
  return (
    // eslint-disable-next-line react/jsx-no-useless-fragment
    <>
      {animalData && speciesData && enclosuresData ? (
        <AnimalForm
          animalData={animalData}
          handleSubmit={handleSubmit}
          enclosuresData={enclosuresData}
          speciesData={speciesData}
        />
      ) : (
        <Loading />
      )}
    </>
  );
}

AnimalUpdate.propTypes = {
  animalId: PropTypes.string.isRequired,
};
