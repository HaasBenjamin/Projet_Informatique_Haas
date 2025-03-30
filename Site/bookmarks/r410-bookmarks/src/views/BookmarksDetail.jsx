import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import Loading from "../components/Loading";
import BookmarksDetails from "../components/BookmarkDetails";
import { getBookmarksDetail } from "../services/api/bookmarks";
import NotFound from "./NotFound";

function BookmarksDetail({ id }) {
  const [bookmarkDetails, setBookmarkDetails] = useState(null);
  useEffect(() => {
    getBookmarksDetail(parseInt(id, 10))
      .then((response) => {
        response.json().then((json) => {
          if (json.status === 404) {
            setBookmarkDetails(undefined);
          } else {
            setBookmarkDetails(json);
          }
        });
      })
      .catch(() => {
        setBookmarkDetails(undefined);
      });
  }, []);
  if (bookmarkDetails === null) {
    return <Loading />;
  }
  if (!bookmarkDetails) {
    return <NotFound description="Ressource non trouvée" />;
  }
  return (
    <BookmarksDetails
      data={{
        bookmarkName: bookmarkDetails.name,
        bookmarkDescription: bookmarkDetails.description,
        bookmarkCreationDate: bookmarkDetails.creationDate,
        bookmarkImage: bookmarkDetails.owner,
        bookmarkAvg: bookmarkDetails.rateAverage,
        owner: bookmarkDetails.owner,
      }}
    />
  );
}

BookmarksDetail.propTypes = {
  id: PropTypes.string,
};

BookmarksDetail.defaultProps = {
  id: { id: 1 },
};
export default BookmarksDetail;
