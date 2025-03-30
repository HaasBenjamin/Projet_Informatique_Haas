import React from "react";
import PropTypes from "prop-types";
import { avatarUrl } from "../services/api/bookmarks";

function UserDetails({ data }) {
  return (
    <article className="bookDetails">
      <dl>
        <dt>- Prénom : </dt>
        <dd>{data.userFirstName}</dd>
        <dt>- Nom</dt>
        <dd>{data.userLastName}</dd>
        <dt>- Login</dt>
        <dd>{data.userLogin}</dd>
        <dt>- Avatar : </dt>
        <dd>
          <img src={avatarUrl(data.userAvatar)} alt="icone" />
        </dd>
      </dl>
    </article>
  );
}

UserDetails.propTypes = {
  data: PropTypes.shape({
    userFirstName: PropTypes.string,
    userLastName: PropTypes.string,
    userLogin: PropTypes.string,
    userAvatar: PropTypes.string,
  }),
};

UserDetails.defaultProps = {
  data: {
    userFirstName: "user",
    userLastName: "user",
    userLogin: "user",
    userAvatar: "/bookmarks/users/1",
  },
};
export default UserDetails;
