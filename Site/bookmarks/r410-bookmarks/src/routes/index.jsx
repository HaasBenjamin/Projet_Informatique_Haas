// eslint-disable-next-line import/no-extraneous-dependencies
import { Route, Switch } from "wouter";
import React from "react";
import PropTypes from "prop-types";
import BookmarkList from "../views/BookmarksList";
import BookmarksDetail from "../views/BookmarksDetail";
import NotFound from "../views/NotFound";
import UserDetail from "../views/UserDetail";

function RouteSwitch({ page, setPage }) {
  return (
    <Switch>
      <Route path="/">
        <BookmarkList page={page} setPage={setPage} />
      </Route>
      <Route path="/bookmarks/:id">
        {(params) => <BookmarksDetail id={params.id} />}
      </Route>
      <Route path="/users/:id">
        {(params) => <UserDetail id={params.id} />}
      </Route>
      <Route component={NotFound} />
    </Switch>
  );
}

RouteSwitch.propTypes = {
  page: PropTypes.number,
  setPage: PropTypes.func,
};

RouteSwitch.defaultProps = {
  page: 1,
  setPage: () => {},
};
export default RouteSwitch;
