import React from "react";
import PropTypes from "prop-types";

export default function Providers({ providers, children }) {
  return providers.reduceRight(
    (acc, Provider) => <Provider>{acc}</Provider>,
    children,
  );
}

Providers.propTypes = {
  providers: PropTypes.arrayOf(PropTypes.elementType).isRequired,
  children: PropTypes.node.isRequired,
};
