import React from "react";
import PropTypes, { shape } from "prop-types";
import Inscription from "./Inscription";

function UserInscriptions({ inscriptions }) {
  return (
    <section className="d-flex flex-wrap justify-content-center">
      {
        inscriptions.map((ins)=>(
        <Inscription data={ins} key={ins.id} />
      ))}
    </section>
  );
}

UserInscriptions.propTypes = {
  inscriptions: PropTypes.arrayOf().isRequired,

};

export default UserInscriptions;
