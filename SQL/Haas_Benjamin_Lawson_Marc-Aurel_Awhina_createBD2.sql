/*==============================================================*/
/* Nom de SGBD :  ORACLE Version 11g                            */
/* Date de création :  18/11/2022 16:31:26                      */
/*==============================================================*/


alter table ABSENCE
   drop constraint FK_ABSENCE_MANQUER_SALARIE;

alter table ACCEDER
   drop constraint FK_ACCEDER_ACCEDER_DOSSIER;

alter table ACCEDER
   drop constraint FK_ACCEDER_ACCEDER2_CONDITIO;

alter table APPARTENIR
   drop constraint FK_APPARTEN_APPARTENI_AGENCE;

alter table APPARTENIR
   drop constraint FK_APPARTEN_APPARTENI_SALARIE;

alter table ASSOCIATION_18
   drop constraint FK_ASSOCIAT_ASSOCIATI_DOSSIER;

alter table ASSOCIATION_18
   drop constraint FK_ASSOCIAT_ASSOCIATI_CLIENT;

alter table ASSOCIATION_18
   drop constraint FK_ASSOCIAT_ASSOCIATI_SALARIE;

alter table CONDUIRE
   drop constraint FK_CONDUIRE_CONDUIRE_DOSSIER;

alter table CONDUIRE
   drop constraint FK_CONDUIRE_CONDUIRE2_VEHICULE;

alter table CONDUIRE
   drop constraint FK_CONDUIRE_CONDUIRE3_SALARIE;

alter table DOSSIER
   drop constraint FK_DOSSIER_CONFIER_AGENCE;

alter table DOSSIER
   drop constraint FK_DOSSIER_CONVENIR_FORMULE;

alter table DOSSIER
   drop constraint FK_DOSSIER_CREER_CLIENT;

alter table DOSSIER
   drop constraint FK_DOSSIER_ETRE_STATUS;

alter table IMMOBILISATION
   drop constraint FK_IMMOBILI_ARRETER_VEHICULE;

alter table IMMOBILISATION
   drop constraint FK_IMMOBILI_REPARER_PRESTATA;

alter table LIER
   drop constraint FK_LIER_LIER_SALARIE;

alter table LIER
   drop constraint FK_LIER_LIER2_ENFANT;

alter table PAYER
   drop constraint FK_PAYER_PAYER_DOSSIER;

alter table PAYER
   drop constraint FK_PAYER_PAYER2_CLIENT;

alter table SALARIE
   drop constraint FK_SALARIE_CORRESPON_TYPE;

alter table SALARIE
   drop constraint FK_SALARIE_RELIER_SALARIE;

alter table SALARIE
   drop constraint FK_SALARIE_RELIER2_SALARIE;

alter table VEHICULE
   drop constraint FK_VEHICULE_CONFORMER_TYPEVEHI;

alter table VEHICULE
   drop constraint FK_VEHICULE_POSSEDER_AGENCE;

alter table VEHICULE
   drop constraint FK_VEHICULE_REFERER_MARQUE;

drop index MANQUER_FK;

drop table ABSENCE cascade constraints;

drop index ACCEDER2_FK;

drop index ACCEDER_FK;

drop table ACCEDER cascade constraints;

drop table AGENCE cascade constraints;

drop index APPARTENIR2_FK;

drop index APPARTENIR_FK;

drop table APPARTENIR cascade constraints;

drop index ASSOCIATION_20_FK;

drop index ASSOCIATION_19_FK;

drop index ASSOCIATION_18_FK;

drop table ASSOCIATION_18 cascade constraints;

drop table CLIENT cascade constraints;

drop table CONDITION cascade constraints;

drop index CONDUIRE3_FK;

drop index CONDUIRE2_FK;

drop index CONDUIRE_FK;

drop table CONDUIRE cascade constraints;

drop index ETRE_FK;

drop index CONVENIR_FK;

drop index CONFIER_FK;

drop index CREER_FK;

drop table DOSSIER cascade constraints;

drop table ENFANT cascade constraints;

drop table FORMULE cascade constraints;

drop index ARRETER_FK;

drop index REPARER_FK;

drop table IMMOBILISATION cascade constraints;

drop index LIER2_FK;

drop index LIER_FK;

drop table LIER cascade constraints;

drop table MARQUE cascade constraints;

drop index PAYER2_FK;

drop index PAYER_FK;

drop table PAYER cascade constraints;

drop table PRESTATAIRE cascade constraints;

drop index RELIER2_FK;

drop index RELIER_FK;

drop index CORRESPONDRE_FK;

drop table SALARIE cascade constraints;

drop table STATUS cascade constraints;

drop table TYPE cascade constraints;

drop table TYPEVEHICULE cascade constraints;

drop index REFERER_FK;

drop index CONFORMER_FK;

drop index POSSEDER_FK;

drop table VEHICULE cascade constraints;

/*==============================================================*/
/* Table : ABSENCE                                              */
/*==============================================================*/
create table ABSENCE 
(
   IDABS                INTEGER              not null,
   IDSAL                INTEGER              not null,
   JOURDEBABS           DATE                 not null,
   JOURFINABS           DATE                 not null,
   DATEDEMANDE          DATE,
   DATEREPONSE          DATE,
   ETAT                 CHAR(2)              not null,
   MOTIF                VARCHAR2(100)        not null,
   constraint PK_ABSENCE primary key (IDABS)
);

/*==============================================================*/
/* Index : MANQUER_FK                                           */
/*==============================================================*/
create index MANQUER_FK on ABSENCE (
   IDSAL ASC
);

/*==============================================================*/
/* Table : ACCEDER                                              */
/*==============================================================*/
create table ACCEDER 
(
   IDDOSSIER            INTEGER              not null,
   IDCONDITION          INTEGER              not null,
   constraint PK_ACCEDER primary key (IDDOSSIER, IDCONDITION)
);

/*==============================================================*/
/* Index : ACCEDER_FK                                           */
/*==============================================================*/
create index ACCEDER_FK on ACCEDER (
   IDDOSSIER ASC
);

/*==============================================================*/
/* Index : ACCEDER2_FK                                          */
/*==============================================================*/
create index ACCEDER2_FK on ACCEDER (
   IDCONDITION ASC
);

/*==============================================================*/
/* Table : AGENCE                                               */
/*==============================================================*/
create table AGENCE 
(
   IDAG                 INTEGER              not null,
   MAILAG               VARCHAR2(100)        not null,
   TELAG                CHAR(10)             not null,
   CPAG                 CHAR(5)              not null,
   RUEAG                VARCHAR2(100)        not null,
   VILLEAG              VARCHAR2(100)        not null,
   NOMAG                VARCHAR2(100)        not null,
   constraint PK_AGENCE primary key (IDAG)
);

/*==============================================================*/
/* Table : APPARTENIR                                           */
/*==============================================================*/
create table APPARTENIR 
(
   IDAG                 INTEGER              not null,
   IDSAL                INTEGER              not null,
   TAUXPRESENCE         INTEGER              not null,
   constraint PK_APPARTENIR primary key (IDAG, IDSAL)
);

/*==============================================================*/
/* Index : APPARTENIR_FK                                        */
/*==============================================================*/
create index APPARTENIR_FK on APPARTENIR (
   IDAG ASC
);

/*==============================================================*/
/* Index : APPARTENIR2_FK                                       */
/*==============================================================*/
create index APPARTENIR2_FK on APPARTENIR (
   IDSAL ASC
);

/*==============================================================*/
/* Table : ASSOCIATION_18                                       */
/*==============================================================*/
create table ASSOCIATION_18 
(
   IDDOSSIER            INTEGER              not null,
   IDCLIENT             INTEGER              not null,
   IDSAL                INTEGER              not null,
   constraint PK_ASSOCIATION_18 primary key (IDDOSSIER, IDCLIENT, IDSAL)
);

/*==============================================================*/
/* Index : ASSOCIATION_18_FK                                    */
/*==============================================================*/
create index ASSOCIATION_18_FK on ASSOCIATION_18 (
   IDDOSSIER ASC
);

/*==============================================================*/
/* Index : ASSOCIATION_19_FK                                    */
/*==============================================================*/
create index ASSOCIATION_19_FK on ASSOCIATION_18 (
   IDCLIENT ASC
);

/*==============================================================*/
/* Index : ASSOCIATION_20_FK                                    */
/*==============================================================*/
create index ASSOCIATION_20_FK on ASSOCIATION_18 (
   IDSAL ASC
);

/*==============================================================*/
/* Table : CLIENT                                               */
/*==============================================================*/
create table CLIENT 
(
   IDCLIENT             INTEGER              not null,
   PRENOMCLIENT         VARCHAR2(100)        not null,
   NOMCLIENT            VARCHAR2(100)        not null,
   MAILCLIENT           VARCHAR2(100)        not null,
   TELCLIENT            CHAR(10)             not null,
   CPCLIENT             CHAR(5)              not null,
   RUECLIENT            VARCHAR2(100)        not null,
   VILLECLIENT          VARCHAR2(100)        not null,
   constraint PK_CLIENT primary key (IDCLIENT)
);

/*==============================================================*/
/* Table : CONDITION                                            */
/*==============================================================*/
create table CONDITION 
(
   IDCONDITION          INTEGER              not null,
   LIBCONDITON          VARCHAR2(100),
   constraint PK_CONDITION primary key (IDCONDITION)
);

/*==============================================================*/
/* Table : CONDUIRE                                             */
/*==============================================================*/
create table CONDUIRE 
(
   IDDOSSIER            INTEGER              not null,
   IDVEHICULE           INTEGER              not null,
   IDSAL                INTEGER              not null,
   NBKMS                INTEGER              not null,
   TPSCONDUITETOTAL     INTEGER              not null,
   constraint PK_CONDUIRE primary key (IDDOSSIER, IDVEHICULE, IDSAL)
);

/*==============================================================*/
/* Index : CONDUIRE_FK                                          */
/*==============================================================*/
create index CONDUIRE_FK on CONDUIRE (
   IDDOSSIER ASC
);

/*==============================================================*/
/* Index : CONDUIRE2_FK                                         */
/*==============================================================*/
create index CONDUIRE2_FK on CONDUIRE (
   IDVEHICULE ASC
);

/*==============================================================*/
/* Index : CONDUIRE3_FK                                         */
/*==============================================================*/
create index CONDUIRE3_FK on CONDUIRE (
   IDSAL ASC
);

/*==============================================================*/
/* Table : DOSSIER                                              */
/*==============================================================*/
create table DOSSIER 
(
   IDDOSSIER            INTEGER              not null,
   IDSTATUS             INTEGER              not null,
   IDCLIENT             INTEGER              not null,
   IDAG                 INTEGER              not null,
   IDFORM               INTEGER              not null,
   DATEOUVERTURE        DATE                 not null,
   CPCHARGEMENT         CHAR(5)              not null,
   RUECHARGEMENT        VARCHAR2(100)        not null,
   VILLECHARGEMENT      VARCHAR2(100)        not null,
   LATITUDECHARGEMENT   FLOAT,
   LONGITUDECHARGEMENT  FLOAT,
   TELCHARGEMENT        CHAR(10),
   CPLIVRAISON          CHAR(5)              not null,
   RUELIVRAISON         VARCHAR2(100)        not null,
   VILLELIVRAISON       VARCHAR2(100)        not null,
   LATITUDELIVRAISON    FLOAT,
   LONGITUDELIVRAISON   FLOAT,
   TELLIVRAISON         CHAR(10),
   DATEPREVUE           DATE,
   DATEVISITE           DATE,
   VOLUMEMOBILIERESTIME INTEGER,
   NBH                  INTEGER,
   constraint PK_DOSSIER primary key (IDDOSSIER)
);

/*==============================================================*/
/* Index : CREER_FK                                             */
/*==============================================================*/
create index CREER_FK on DOSSIER (
   IDCLIENT ASC
);

/*==============================================================*/
/* Index : CONFIER_FK                                           */
/*==============================================================*/
create index CONFIER_FK on DOSSIER (
   IDAG ASC
);

/*==============================================================*/
/* Index : CONVENIR_FK                                          */
/*==============================================================*/
create index CONVENIR_FK on DOSSIER (
   IDFORM ASC
);

/*==============================================================*/
/* Index : ETRE_FK                                              */
/*==============================================================*/
create index ETRE_FK on DOSSIER (
   IDSTATUS ASC
);

/*==============================================================*/
/* Table : ENFANT                                               */
/*==============================================================*/
create table ENFANT 
(
   IDENFANT             INTEGER              not null,
   NOMENFANT            VARCHAR2(100)        not null,
   PRENOMENFANT         VARCHAR2(100)        not null,
   DATENAISSENFANT      DATE                 not null,
   constraint PK_ENFANT primary key (IDENFANT)
);

/*==============================================================*/
/* Table : FORMULE                                              */
/*==============================================================*/
create table FORMULE 
(
   IDFORM               INTEGER              not null,
   LIBFORM              VARCHAR2(100)        not null,
   PRIXFORMHT           FLOAT                not null,
   constraint PK_FORMULE primary key (IDFORM)
);

/*==============================================================*/
/* Table : IMMOBILISATION                                       */
/*==============================================================*/
create table IMMOBILISATION 
(
   IDIMMOBILISATION     INTEGER              not null,
   IDVEHICULE           INTEGER              not null,
   IDPRESTAIRE          INTEGER,
   LIBIMMOBILISATION    VARCHAR2(100)        not null,
   INFORMATIONSUPP      VARCHAR2(100)        not null,
   DEBIMMOBILISATION    DATE                 not null,
   FINIMMOBILISATION    DATE                 not null,
   constraint PK_IMMOBILISATION primary key (IDIMMOBILISATION)
);

/*==============================================================*/
/* Index : REPARER_FK                                           */
/*==============================================================*/
create index REPARER_FK on IMMOBILISATION (
   IDPRESTAIRE ASC
);

/*==============================================================*/
/* Index : ARRETER_FK                                           */
/*==============================================================*/
create index ARRETER_FK on IMMOBILISATION (
   IDVEHICULE ASC
);

/*==============================================================*/
/* Table : LIER                                                 */
/*==============================================================*/
create table LIER 
(
   IDSAL                INTEGER              not null,
   IDENFANT             INTEGER              not null,
   ROLE                 VARCHAR2(100)        not null,
   constraint PK_LIER primary key (IDSAL, IDENFANT)
);

/*==============================================================*/
/* Index : LIER_FK                                              */
/*==============================================================*/
create index LIER_FK on LIER (
   IDSAL ASC
);

/*==============================================================*/
/* Index : LIER2_FK                                             */
/*==============================================================*/
create index LIER2_FK on LIER (
   IDENFANT ASC
);

/*==============================================================*/
/* Table : MARQUE                                               */
/*==============================================================*/
create table MARQUE 
(
   IDMARQUE             INTEGER              not null,
   LIBMARQUE            CHAR(10)             not null,
   constraint PK_MARQUE primary key (IDMARQUE)
);

/*==============================================================*/
/* Table : PAYER                                                */
/*==============================================================*/
create table PAYER 
(
   IDDOSSIER            INTEGER              not null,
   IDCLIENT             INTEGER              not null,
   DATEPAYEMENT         DATE,
   constraint PK_PAYER primary key (IDDOSSIER, IDCLIENT)
);

/*==============================================================*/
/* Index : PAYER_FK                                             */
/*==============================================================*/
create index PAYER_FK on PAYER (
   IDDOSSIER ASC
);

/*==============================================================*/
/* Index : PAYER2_FK                                            */
/*==============================================================*/
create index PAYER2_FK on PAYER (
   IDCLIENT ASC
);

/*==============================================================*/
/* Table : PRESTATAIRE                                          */
/*==============================================================*/
create table PRESTATAIRE 
(
   IDPRESTAIRE          INTEGER              not null,
   TELPRESTATAIRE       CHAR(10)             not null,
   NOMPRESTAIRE         VARCHAR2(100)        not null,
   CPPRESTATAIRE        CHAR(5)              not null,
   RUEPRESTATOIRE       VARCHAR2(100)        not null,
   VILLEPRESTATOIRE     VARCHAR2(100)        not null,
   constraint PK_PRESTATAIRE primary key (IDPRESTAIRE)
);

/*==============================================================*/
/* Table : SALARIE                                              */
/*==============================================================*/
create table SALARIE 
(
   IDSAL                INTEGER              not null,
   SAL_IDSAL            INTEGER,
   SAL_IDSAL2           INTEGER,
   IDTYPE               INTEGER              not null,
   NOMSAL               VARCHAR2(100)        not null,
   PRENOMSAL            VARCHAR2(100)        not null,
   CPSAL                CHAR(5)              not null,
   RUESAL               VARCHAR2(100)        not null,
   VILLESAL             VARCHAR2(100)        not null,
   TELSAL               CHAR(10)             not null,
   PERMIS               CHAR(12),
   ANNEEEMBAUCHE        DATE                 not null,
   MAILSAL              VARCHAR2(100)        not null,
   CAPACITECHEF         RAW(1)               not null,
   DATENAISSSAL         DATE                 not null,
   constraint PK_SALARIE primary key (IDSAL)
);

/*==============================================================*/
/* Index : CORRESPONDRE_FK                                      */
/*==============================================================*/
create index CORRESPONDRE_FK on SALARIE (
   IDTYPE ASC
);

/*==============================================================*/
/* Index : RELIER_FK                                            */
/*==============================================================*/
create index RELIER_FK on SALARIE (
   SAL_IDSAL2 ASC
);

/*==============================================================*/
/* Index : RELIER2_FK                                           */
/*==============================================================*/
create index RELIER2_FK on SALARIE (
   SAL_IDSAL ASC
);

/*==============================================================*/
/* Table : STATUS                                               */
/*==============================================================*/
create table STATUS 
(
   IDSTATUS             INTEGER              not null,
   LIBSTATUS            VARCHAR2(100)        not null,
   constraint PK_STATUS primary key (IDSTATUS)
);

/*==============================================================*/
/* Table : TYPE                                                 */
/*==============================================================*/
create table TYPE 
(
   IDTYPE               INTEGER              not null,
   LIBTYPE              VARCHAR2(100)        not null,
   constraint PK_TYPE primary key (IDTYPE)
);

/*==============================================================*/
/* Table : TYPEVEHICULE                                         */
/*==============================================================*/
create table TYPEVEHICULE 
(
   IDTYPEVEHICULE       INTEGER              not null,
   LIBTYPEVEHICULE      VARCHAR2(100)        not null,
   constraint PK_TYPEVEHICULE primary key (IDTYPEVEHICULE)
);

/*==============================================================*/
/* Table : VEHICULE                                             */
/*==============================================================*/
create table VEHICULE 
(
   IDVEHICULE           INTEGER              not null,
   IDTYPEVEHICULE       INTEGER              not null,
   IDMARQUE             INTEGER              not null,
   IDAG                 INTEGER              not null,
   IMMATRICULATION      CHAR(9)              not null,
   HAYON                RAW(1)               not null,
   COUCHETTE            RAW(1)               not null,
   VOLUMEUTILE          INTEGER              not null,
   DISPONIBLE           RAW(1)               not null,
   FREQUENCE            INTEGER              not null,
   CONSOMMATIONCARBURANT INTEGER              not null,
   NBPLACE              INTEGER              not null,
   constraint PK_VEHICULE primary key (IDVEHICULE)
);

/*==============================================================*/
/* Index : POSSEDER_FK                                          */
/*==============================================================*/
create index POSSEDER_FK on VEHICULE (
   IDAG ASC
);

/*==============================================================*/
/* Index : CONFORMER_FK                                         */
/*==============================================================*/
create index CONFORMER_FK on VEHICULE (
   IDTYPEVEHICULE ASC
);

/*==============================================================*/
/* Index : REFERER_FK                                           */
/*==============================================================*/
create index REFERER_FK on VEHICULE (
   IDMARQUE ASC
);

alter table ABSENCE
   add constraint FK_ABSENCE_MANQUER_SALARIE foreign key (IDSAL)
      references SALARIE (IDSAL);

alter table ACCEDER
   add constraint FK_ACCEDER_ACCEDER_DOSSIER foreign key (IDDOSSIER)
      references DOSSIER (IDDOSSIER);

alter table ACCEDER
   add constraint FK_ACCEDER_ACCEDER2_CONDITIO foreign key (IDCONDITION)
      references CONDITION (IDCONDITION);

alter table APPARTENIR
   add constraint FK_APPARTEN_APPARTENI_AGENCE foreign key (IDAG)
      references AGENCE (IDAG);

alter table APPARTENIR
   add constraint FK_APPARTEN_APPARTENI_SALARIE foreign key (IDSAL)
      references SALARIE (IDSAL);

alter table ASSOCIATION_18
   add constraint FK_ASSOCIAT_ASSOCIATI_DOSSIER foreign key (IDDOSSIER)
      references DOSSIER (IDDOSSIER);

alter table ASSOCIATION_18
   add constraint FK_ASSOCIAT_ASSOCIATI_CLIENT foreign key (IDCLIENT)
      references CLIENT (IDCLIENT);

alter table ASSOCIATION_18
   add constraint FK_ASSOCIAT_ASSOCIATI_SALARIE foreign key (IDSAL)
      references SALARIE (IDSAL);

alter table CONDUIRE
   add constraint FK_CONDUIRE_CONDUIRE_DOSSIER foreign key (IDDOSSIER)
      references DOSSIER (IDDOSSIER);

alter table CONDUIRE
   add constraint FK_CONDUIRE_CONDUIRE2_VEHICULE foreign key (IDVEHICULE)
      references VEHICULE (IDVEHICULE);

alter table CONDUIRE
   add constraint FK_CONDUIRE_CONDUIRE3_SALARIE foreign key (IDSAL)
      references SALARIE (IDSAL);

alter table DOSSIER
   add constraint FK_DOSSIER_CONFIER_AGENCE foreign key (IDAG)
      references AGENCE (IDAG);

alter table DOSSIER
   add constraint FK_DOSSIER_CONVENIR_FORMULE foreign key (IDFORM)
      references FORMULE (IDFORM);

alter table DOSSIER
   add constraint FK_DOSSIER_CREER_CLIENT foreign key (IDCLIENT)
      references CLIENT (IDCLIENT);

alter table DOSSIER
   add constraint FK_DOSSIER_ETRE_STATUS foreign key (IDSTATUS)
      references STATUS (IDSTATUS);

alter table IMMOBILISATION
   add constraint FK_IMMOBILI_ARRETER_VEHICULE foreign key (IDVEHICULE)
      references VEHICULE (IDVEHICULE);

alter table IMMOBILISATION
   add constraint FK_IMMOBILI_REPARER_PRESTATA foreign key (IDPRESTAIRE)
      references PRESTATAIRE (IDPRESTAIRE);

alter table LIER
   add constraint FK_LIER_LIER_SALARIE foreign key (IDSAL)
      references SALARIE (IDSAL);

alter table LIER
   add constraint FK_LIER_LIER2_ENFANT foreign key (IDENFANT)
      references ENFANT (IDENFANT);

alter table PAYER
   add constraint FK_PAYER_PAYER_DOSSIER foreign key (IDDOSSIER)
      references DOSSIER (IDDOSSIER);

alter table PAYER
   add constraint FK_PAYER_PAYER2_CLIENT foreign key (IDCLIENT)
      references CLIENT (IDCLIENT);

alter table SALARIE
   add constraint FK_SALARIE_CORRESPON_TYPE foreign key (IDTYPE)
      references TYPE (IDTYPE);

alter table SALARIE
   add constraint FK_SALARIE_RELIER_SALARIE foreign key (SAL_IDSAL2)
      references SALARIE (IDSAL);

alter table SALARIE
   add constraint FK_SALARIE_RELIER2_SALARIE foreign key (SAL_IDSAL)
      references SALARIE (IDSAL);

alter table VEHICULE
   add constraint FK_VEHICULE_CONFORMER_TYPEVEHI foreign key (IDTYPEVEHICULE)
      references TYPEVEHICULE (IDTYPEVEHICULE);

alter table VEHICULE
   add constraint FK_VEHICULE_POSSEDER_AGENCE foreign key (IDAG)
      references AGENCE (IDAG);

alter table VEHICULE
   add constraint FK_VEHICULE_REFERER_MARQUE foreign key (IDMARQUE)
      references MARQUE (IDMARQUE);

