import Navbar from "react-bootstrap/Navbar";
import "bootstrap/dist/css/bootstrap.min.css";
import PropTypes from "prop-types";
import React from "react";
import { Container, Nav } from "react-bootstrap";
import UserProvider from "../../Contexts/User/UserProvider.jsx";
import UserButton from "../Atomic/UserButton.jsx";
import Providers from "../../Contexts/Providers.jsx";
import SeeMyInscription from "../Atomic/SeeMyInscription.jsx";

function NavBar({ links = [] }) {
  return (
    <>
      <link rel="stylesheet" href="/css/navbar.css" />
      <Navbar className="navbar-custom navbar-light" expand="lg">
        {" "}
        {/* Ajout de la classe navbar-light */}
        <Container>
          <Navbar.Brand href="/">Accueil</Navbar.Brand>
          <Navbar.Toggle aria-controls="basic-navbar-nav" />{" "}
          {/* Bouton burger */}
          <Navbar.Collapse id="basic-navbar-nav">
            {" "}
            {/* Contenu qui sera affiché après le clic sur le bouton burger */}
            <Nav className="me-auto">
              {links.map((link) => (
                <Nav.Link key={link.id} href={link.link}>
                  {link.name}
                </Nav.Link>
              ))}
            </Nav>
            <UserButton />
            <SeeMyInscription />
          </Navbar.Collapse>
        </Container>
      </Navbar>
    </>
  );
}

NavBar.propTypes = {
  links: PropTypes.arrayOf(
    PropTypes.shape({
      link: PropTypes.string.isRequired,
      name: PropTypes.string.isRequired,
      id: PropTypes.number,
    }),
  ).isRequired,
};

export default NavBar;
