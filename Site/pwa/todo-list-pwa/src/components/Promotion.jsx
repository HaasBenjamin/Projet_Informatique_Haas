import {usePWA} from "../hooks/usePWA.js";
import InstallDesktopIcon from '@mui/icons-material/InstallDesktop';
import CachedIcon from '@mui/icons-material/Cached';
import WarningIcon from '@mui/icons-material/Warning';
import RefreshIcon from '@mui/icons-material/Refresh';
import PropTypes from "prop-types";

export default function Promotion({networkError, checkNetwork}) {
    const installPWA = usePWA();
    return (<>
        {networkError ? <span><button className={"btn btn-outline-secondary mx-1"} onClick={()=>{checkNetwork()}}><RefreshIcon /></button><button className={"install btn btn-outline-danger"}><WarningIcon /> Mode Hors Ligne</button></span> : ''}
        {installPWA.updatable ? <button className={"install btn btn-outline-secondary"} onClick={()=>{installPWA.updateSW(true).then()}}><CachedIcon /></button> : ''}
        {installPWA.installable ? <button className={"install btn btn-outline-secondary"} onClick={()=>{installPWA.install()}}><InstallDesktopIcon /></button> : ''}
    </>);
}

Promotion.propTypes = {
    networkError: PropTypes.bool.isRequired,
    checkNetwork: PropTypes.func.isRequired,
}