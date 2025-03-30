import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import Loading from "../components/Loading";
import NotFound from "./NotFound";
import { fetchAllBookmarks } from "../services/api/bookmarks";
import PaginationFromHydraView from "../services/transformers/paginationFromHydraView";
import Pagination from "../components/Pagination";
import BookmarksList from "../components/BookmarksList";

function BookmarkList({ page, setPage }) {
  const [bookmarkList, setBookmarkList] = useState(null);
  const [pagination, setPagination] = useState();
  useEffect(() => {
    setBookmarkList(null);
    fetchAllBookmarks(new URLSearchParams(`page=${page}`)).then((response) => {
      setBookmarkList(response["hydra:member"]);
      setPagination(PaginationFromHydraView(response["hydra:view"]));
    });
  }, [page]);
  if (bookmarkList === null) {
    return <Loading />;
  }
  if (!bookmarkList) {
    return <NotFound description="Ressource non trouvée" />;
  }
  return (
    <>
      <BookmarksList bookmarksData={bookmarkList} />
      {pagination && (
        <Pagination
          pagination={pagination}
          onClick={(pageId) => {
            setPage(pageId);
          }}
        />
      )}
    </>
  );
}

BookmarkList.propTypes = {
  page: PropTypes.number.isRequired,
  setPage: PropTypes.func.isRequired,
};

export default BookmarkList;
