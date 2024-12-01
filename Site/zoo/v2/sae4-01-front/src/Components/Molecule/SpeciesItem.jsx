import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import { SpeciesDietName } from "../Page/FetchHook";

function SpeciesItem({ data }) {
  const [dietName, setDietName] = useState("");
  useEffect(() => {
    setDietName("Aucune");
    SpeciesDietName(data.id).then((json) => {
      setDietName(json.name);
    });
  }, []);
  return (
    <li className="border-end border-bottom mb-3">
      <a
        className="link-style d-flex flex-row-reverse justify-content-end align-content-center gap-5"
        href={`/species/${data.id}/animals`}
        style={{ color: "white", textDecoration: "none" }}
      >
        <div className="w-100 d-flex flex-column justify-content-around">
          <span>{data.name}</span>
          <span>{data.description}</span>
        </div>
        <div className="mb-2">
          {data.image && (
            <img
              src={`http://localhost:8000${data.image}`}
              width="256"
              height="256"
            />
          )}
          {!data.image && (
            <img src="/img/default.png" alt="" width="256" height="256" />
          )}
        </div>
        <div className="d-flex flex-column justify-content-around">
          <span>{dietName}</span>
        </div>
      </a>
    </li>
  );
}

SpeciesItem.propTypes = {
  data: PropTypes.shape({
    id: PropTypes.number,
    name: PropTypes.string,
    description: PropTypes.string,
    diet: PropTypes.string,
    image: PropTypes.string,
  }).isRequired,
};

export default SpeciesItem;
