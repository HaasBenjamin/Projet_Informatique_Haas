import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import Loading from "../Atomic/Loading";
import NotFound from "./NotFound";
import { getUserDetail } from "../../api/zoo";
import UserInscriptions from "../Molecule/UserInscription";
import { fetchRegistrationsCollection } from "./FetchHook";

export default function UserDetail({ params }) {
  const [userData, setUserData] = useState();
  const [inscriptions, setInscriptions] = useState();
  useEffect(() => {
    setUserData(null);
    getUserDetail(params.id)
      .then((json) => {
        setUserData(json);
      })
      .catch(() => setUserData());
  }, [params]);

  useEffect(() => {

    if (userData) {

      fetchRegistrationsCollection().then((response) =>{
        console.log(response);
        return setInscriptions(response["hydra:member"]);
      });
    }
  }, [userData]);
  if (userData === undefined) {
    return <NotFound />;
  }
  return !userData ? (
    <Loading />
  ) : (
    <>
      <section className="userDetail">
        <h2>
          {userData.firstname} {userData.lastname}
        </h2>
        <ul>
          <li>Login : {userData.login}</li>
        </ul>
      </section>
      {!inscriptions ? (
        <Loading />
      ) : (
        <UserInscriptions inscriptions={inscriptions} />
      )}
    </>
  );
}

UserDetail.propTypes = {
  params: PropTypes.shape({
    id: PropTypes.string.isRequired,
  }),
};
