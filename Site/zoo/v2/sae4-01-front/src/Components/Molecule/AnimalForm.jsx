import React from "react";
import PropTypes from "prop-types";

export default function AnimalForm({
  animalData,
  enclosuresData,
  speciesData,
  handleSubmit,
}) {
  return (
    <form
      name="animal"
      method="post"
      encType="multipart/form-data"
      onSubmit={(event) => {
        handleSubmit(event);
      }}
      className="m-5"
    >
      <div className="mb-3">
        <label
          htmlFor="animal_name"
          className="form-label required"
          aria-label="animal_name"
        >
          Nom de l&#039;animal
        </label>
        <input
          type="text"
          id="animal_name"
          name="animal[name]"
          required="required"
          maxLength="128"
          className="form-control"
          defaultValue={animalData.name}
        />
      </div>
      <div className="mb-3">
        <label htmlFor="animal_description" className="form-label required">
          Description de l&#039;animal
        </label>
        <input
          type="text"
          id="animal_description"
          name="animal[description]"
          required="required"
          maxLength="512"
          className="form-control"
          defaultValue={animalData.description}
        />
      </div>
      <div>
        <label htmlFor="animal_specie" className="form-label required">
          Espèce de l&#039;animal
        </label>
        <select
          id="animal_specie"
          name="animal[species]"
          required="required"
          className="form-select"
          defaultValue={animalData.species.id}
        >
          <option value="">Espèce ?</option>
          {speciesData.map((specie) => (
            <option value={specie.id} key={specie.id}>
              {specie.name}
            </option>
          ))}
        </select>
      </div>
      <div>
        <label htmlFor="animal_enclosure" className="form-label required">
          Enclos de l&#039;animal
        </label>
        <select
          id="animal_enclosure"
          name="animal[enclosure]"
          required="required"
          className="form-select"
          defaultValue={animalData.enclosure.id}
        >
          <option value=""> Enclos ?</option>
          {enclosuresData.map((enclosure) => (
            <option value={enclosure.id} key={enclosure.id}>
              {enclosure.name}
            </option>
          ))}
        </select>
      </div>
      <div className="mb-3">
        <label htmlFor="animal_image" className="form-label">
          {/* eslint-disable-next-line react/no-unescaped-entities */}
          Image de l'animal
        </label>
        <input
          type="file"
          id="animal_image"
          name="animal[image]"
          className="form-control"
        />
      </div>

      <button
        aria-label="submit_button"
        type="submit"
        className="w-100 d-inline-block btn btn-primary"
      >
        Modifier
      </button>
    </form>
  );
}

AnimalForm.propTypes = {
  animalData: PropTypes.shape({
    "@context": PropTypes.string,
    "@id": PropTypes.string,
    "@type": PropTypes.string,
    description: PropTypes.string,
    enclosure: PropTypes.shape({
      "@id": PropTypes.string,
      "@type": PropTypes.string,
      id: PropTypes.number,
      name: PropTypes.string,
    }),
    id: PropTypes.number,
    image: PropTypes.string,
    name: PropTypes.string,
    species: PropTypes.shape({
      "@id": PropTypes.string,
      "@type": PropTypes.string,
      id: PropTypes.number,
      name: PropTypes.string,
    }),
  }).isRequired,
  enclosuresData: PropTypes.arrayOf(
    PropTypes.shape({
      "@id": PropTypes.string,
      "@type": PropTypes.string,
      id: PropTypes.number,
      name: PropTypes.string,
    }),
  ).isRequired,
  speciesData: PropTypes.arrayOf(
    PropTypes.shape({
      "@id": PropTypes.string,
      "@type": PropTypes.string,
      animals: PropTypes.arrayOf(PropTypes.string),
      description: PropTypes.string,
      diet: PropTypes.string,
      family: PropTypes.string,
      id: PropTypes.number,
      name: PropTypes.string,
    }),
  ).isRequired,
  handleSubmit: PropTypes.func.isRequired,
};
