import React, { useContext } from "react";
import PropTypes from "prop-types";
import { themeContext } from "../context/Theme/index";

export default function LoginForm({ onSubmit }) {
  const { theme } = useContext(themeContext);
  return (
    <form
      onSubmit={onSubmit}
      className="d-flex flex-column align-self-center"
      method="post"
    >
      <h4 style={{ color: theme.palette.primary.main }}>
        Formulaire de connexion
      </h4>
      <div className="form-group mb-3">
        {/* eslint-disable-next-line jsx-a11y/label-has-associated-control */}
        <label
          htmlFor="login"
          className="mb-1"
          style={{ color: theme.palette.primary.main }}
        >
          Login
        </label>
        <input
          type="text"
          className="form-control"
          name="login"
          id="login"
          placeholder="Login"
        />
      </div>
      <div className="form-group mb-3">
        {/* eslint-disable-next-line jsx-a11y/label-has-associated-control */}
        <label
          htmlFor="password"
          className="mb-1"
          style={{ color: theme.palette.primary.main }}
        >
          Password
        </label>
        <input
          type="password"
          className="form-control"
          name="password"
          id="password"
          placeholder="Password"
        />
      </div>
      <div className="form-check mb-3">
        <input
          name="keeplogin"
          type="checkbox"
          className="form-check-input"
          id="keeplogin"
        />
        {/* eslint-disable-next-line jsx-a11y/label-has-associated-control */}
        <label
          className="form-check-label"
          htmlFor="keeplogin"
          style={{ color: theme.palette.primary.main }}
        >
          Keep log in
        </label>
      </div>
      <div className="mb-3">
        <a
          href="https://iut-rcc-infoapi.univ-reims.fr/tasks/register"
          className="text-decoration-none"
          target="_blank"
          rel="noreferrer"
        >
          S&#39;inscrire
        </a>
        <a
          href="https://iut-rcc-infoapi.univ-reims.fr/tasks/register"
          className="text-decoration-none mx-1"
          target="_blank"
          rel="noreferrer"
        >
          Réinitialiser le mot de passe
        </a>
      </div>
      <button type="submit" className="btn btn-primary">
        S&#39;authentifier
      </button>
    </form>
  );
}

LoginForm.propTypes = {
  onSubmit: PropTypes.func.isRequired,
};
