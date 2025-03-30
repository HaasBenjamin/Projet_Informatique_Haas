import React from "react";
import PropTypes from "prop-types";
import Rating from "./Rating";
import { avatarUrl } from "../services/api/bookmarks";

function BookmarkDetails({ data }) {
  return (
    <article className="bookDetails">
      <dl>
        <dt>- Nom du signet : </dt>
        <dd>{data.bookmarkName}</dd>
        <dt>- Propriétaire : </dt>
        <dd>
          <a href={`/users/${data.bookmarkImage.split("/").pop()}`}>
            <img src={avatarUrl(data.bookmarkImage)} alt="icone" />
          </a>
        </dd>
        <dt>- Description du signet</dt>
        <dd>{data.bookmarkDescription}</dd>
        <dt>- Date de création du signet</dt>
        <dd>{data.bookmarkCreationDate}</dd>
        <dt>- Moyenne des notes du signet</dt>
        <dd>
          <Rating value={data.bookmarkAvg} />
        </dd>
      </dl>
    </article>
  );
}

BookmarkDetails.propTypes = {
  data: PropTypes.shape({
    bookmarkName: PropTypes.string,
    bookmarkDescription: PropTypes.string,
    bookmarkCreationDate: PropTypes.string,
    bookmarkImage: PropTypes.string,
    bookmarkAvg: PropTypes.number,
  }),
};

BookmarkDetails.defaultProps = {
  data: {
    bookmarkName: "bookmark",
    bookmarkDescription: "bookmark description",
    bookmarkCreationDate: "2024-01-00T00:00:00+00:00",
    bookmarkImage: "/bookmarks/users/1",
    bookmarkAvg: 0,
  },
};
export default BookmarkDetails;
