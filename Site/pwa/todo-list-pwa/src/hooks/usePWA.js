import {useEffect, useState} from "react";
import {useRegisterSW} from "virtual:pwa-register/react";

export const usePWA = () => {
    const [installable, setInstallable] = useState(false);
    const [installer, setInstaller] = useState(null)
    const register = useRegisterSW();
    useEffect(() => {
        window.addEventListener('beforeinstallprompt',(e)=>{
            e.preventDefault();
            setInstallable(true);
            setInstaller(e)
        console.log('test')})
        window.addEventListener('appinstalled', async () => {
            setInstaller(null)
            setInstallable(false);
        });
    }, []);
    const installPWA = () => {
        installer.prompt();
    }
    return {install : installPWA, installable: installable, updatable: register.needRefresh[0], updateSW: register.updateServiceWorker};
}