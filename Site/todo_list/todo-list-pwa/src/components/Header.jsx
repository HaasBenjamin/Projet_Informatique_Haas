import Promotion from "./Promotion.jsx";
import PropTypes from "prop-types";

export default function Header({networkError,checkNetwork}) {
    return (
        <header>
            <h1>My Wonderful Todo List</h1>
            <span className={"header_right"}>
                <Promotion networkError={networkError} checkNetwork={checkNetwork} />
                <img src="/icons/icon-512x512.png" alt="logo" width="64" height="64"/>
            </span>
        </header>
    )
}

Header.propTypes = {
    networkError: PropTypes.bool.isRequired,
    checkNetwork: PropTypes.func.isRequired,
}
