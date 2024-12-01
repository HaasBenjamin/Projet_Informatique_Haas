import Button from "react-bootstrap/Button";
import Form from "react-bootstrap/Form";
import React from "react";
import PropTypes from "prop-types";
import { useLocation } from "wouter";


export default function SearchForm({ placeholder, label}) {
  const [, setLocation] = useLocation();
  const handleSubmit = (event) => {
    event.preventDefault();
    setLocation(`/animals/${event.target[0].value}`);
  };
  return (
    <Form
      className="d-flex searchForm"
      onSubmit={(event) => {
        handleSubmit(event);
      }}
    >
      <Form.Control
        type="search"
        placeholder={placeholder}
        className="me-2"
        aria-label="Search"
      />
      <Button type="submit" variant="success">
        {label}
      </Button>
    </Form>
  );
}

SearchForm.propTypes = {
  placeholder: PropTypes.string,
  label: PropTypes.string,
};

SearchForm.defaultProps = {
  placeholder: "Search",
  label: "Search",
};
