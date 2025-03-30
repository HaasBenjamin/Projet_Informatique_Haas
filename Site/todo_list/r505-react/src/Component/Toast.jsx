import * as React from 'react';
import {Alert, IconButton, Snackbar} from "@mui/material";
import {useEffect, useState} from "react";

function CloseIcon() {
    return null;
}

export function Toast({duration, onDelete, onHide, notifications, setNotifications}) {
    const [open, setOpen] = useState(notifications.length > 0);
    const [messageInfo, setMessageInfo] = useState(undefined);

    useEffect(() => {
        if (notifications.length && !messageInfo) {
            setMessageInfo({ ...notifications[0] });
            setNotifications((prev) => prev.slice(1));
            setOpen(true);
        } else if (notifications.length && messageInfo && open) {
            onHide(messageInfo.id);
            setOpen(false);
        }
    }, [notifications, messageInfo, open]);



    const handleClose = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }
        if (messageInfo) {
            onHide(messageInfo.id);
        }
        setOpen(false);
    };

    useEffect(() => {
        const handleKeyDown = (event) => {
            if (event.key === 'Escape') {
                handleClose();
            }
        };
        window.addEventListener('keydown', handleKeyDown);
        return () => {
            window.removeEventListener('keydown', handleKeyDown);
        };
    }, [messageInfo]);

    const handleExited = () => {
        setMessageInfo(undefined);
    };
    const handleDelete = () => {
        if (messageInfo) {
            onDelete(messageInfo.id);
        }
        setOpen(false);
    };


    return (
        <Snackbar
            key={messageInfo ? messageInfo.id : undefined}
            open={open}
            autoHideDuration={duration}
            onClose={handleClose}
            TransitionProps={{ onExited: handleExited }}
            anchorOrigin={{vertical: 'bottom', horizontal: 'right' }}
        >
            <Alert
                onClick={handleClose}
                onClose={handleClose}
                action={
                    <IconButton
                        size="small"
                        aria-label="close"
                        color="inherit"
                        onClick={handleDelete}
                    >
                        <CloseIcon fontSize="small" />
                    </IconButton>
                }
                severity={messageInfo ? messageInfo.typeNotification : 'error'}
                variant="filled"
                sx={{ width: '100%' }}
            >
                {messageInfo ? messageInfo.content : ''}
            </Alert>
        </Snackbar>
    );
}