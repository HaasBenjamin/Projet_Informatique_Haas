import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import { CurrentUserContext } from "./User";
import { getMe } from "../../api/zoo";

export default function UserProvider({ children = null }) {
  const [userData, setUserData] = useState();

  useEffect(() => {
    getMe().then(setUserData);
  }, [getMe, setUserData]);

  return (
    <CurrentUserContext.Provider value={userData}>
      {children}
    </CurrentUserContext.Provider>
  );
}

UserProvider.propTypes = {
  children: PropTypes.node,
};
