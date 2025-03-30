import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import LevelContext from "./index";
import { getMe } from "../../services/api/bookmarks";

export default function Section({ level }) {
  const [userData, setUserData] = useState(undefined);
  useEffect(() => {
    getMe().then((response) => {
      if (response) {
        setUserData(response);
      }
    });
  }, []);
  return (
    <section className="section">
      {userData && (
        <LevelContext.Provider value={level}>
          <section>Utilisateur : {userData.login}</section>
        </LevelContext.Provider>
      )}
    </section>
  );
}

Section.propTypes = {
  level: PropTypes.number,
};

Section.defaultProps = {
  level: 1,
};
