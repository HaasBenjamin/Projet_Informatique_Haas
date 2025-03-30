import PropTypes from "prop-types";

export default function PaginationFromHydraView(hydraview) {
  if (hydraview?.["hydra:last"]) {
    const { "@id": id, "hydra:last": last } = hydraview;
    const cur = parseInt(new URLSearchParams(id.split("?")[1]).get("page"), 10);
    const la = parseInt(
      new URLSearchParams(last.split("?")[1]).get("page"),
      10,
    );
    return {
      current: cur,
      first: 1,
      previous: hydraview?.["hydra:previous"] ? cur - 1 : undefined,
      next: hydraview?.["hydra:next"] ? cur + 1 : undefined,
      last: la,
    };
  }
  return null;
}

PaginationFromHydraView.propTypes = {
  hydraview: PropTypes.shape({
    "@id": PropTypes.string,
    "hydra:last": PropTypes.string,
    "hydra:previous": PropTypes.string,
    "hydra:next": PropTypes.string,
  }),
};

PaginationFromHydraView.defaultProps = {
  hydraview: {
    "@id": "api/tests?page=1",
    "hydra:last": "api/tests?page=1",
    "hydra:previous": "api/tests?page=1",
    "hydra:next": "api/tests?page=1",
  },
};
