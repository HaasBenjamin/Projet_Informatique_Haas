# Créé par beben, le 01/03/2023 en Python 3.7
import pygame
import os
import time
from random import choice,randint
from Maze_Haas_Lawson import *


largeur=700
hauteur=700
largeur_rec=140
hauteur_rec=40
def creer_onglet(largeur_rec,hauteur_rec):
    '''permet de créer la page'''
    global largeur
    global hauteur
    #initialisation
    pygame.init()
    pygame.font.init()
    pygame.mixer.init()
    #création fenetre
    screen = pygame.display.set_mode((largeur, hauteur), pygame.FULLSCREEN)

    pygame.display.set_caption("Lawsbyrinthe")
    #ajout du fond d'écran
    bckgrd=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/jungletextel.jpg")),(largeur,hauteur))
    screen.blit(bckgrd,(0,0))
    pygame.display.update()
    taille=screen.get_size()
    largeur=taille[0]
    hauteur=taille[1]


    #ajout rectangle servant de bouton avec texte

    pygame.draw.rect(screen,pygame.Color('dark green'),[largeur*1/2-1/2*largeur_rec,hauteur-hauteur*1/5,largeur_rec,hauteur_rec])
    smallfont = pygame.font.SysFont('bouton',35)
    text = smallfont.render('PLAY' , True , pygame.Color('white'))
    screen.blit(text , (largeur*1/2-1/2*largeur_rec+largeur_rec*1/4,hauteur-hauteur*1/5+hauteur_rec*1/4))
    pygame.display.update()

    return screen



def main(largeur_rec,hauteur_rec):
    '''fonction principale gérant l'intégralité et le lancement du jeu'''
    lancer=False

    screen=creer_onglet(largeur_rec,hauteur_rec)
    global largeur
    global hauteur
    # page d'accueil
    while not lancer :
        for event in pygame.event.get(): # récupération de tous les évenements
            if event.type ==pygame.QUIT: #cas ou on ferme la fenetre
                pygame.quit()
                exit()
                lancer = True

            if event.type == pygame.MOUSEBUTTONDOWN: # cas ou on clic

                pos=pygame.mouse.get_pos()  # recupération position du clic
                posrecdebx=largeur*1/2-1/3*largeur_rec
                posrecfinx=largeur*1/2-1/3*largeur_rec+largeur_rec
                posrecdeby=hauteur-hauteur*1/5
                posrecfiny=hauteur-hauteur*1/5+hauteur_rec
                if pos[0]>=posrecdebx and pos[0]<=posrecfinx and pos[1]>=posrecdeby and pos[1]<=posrecfiny:
                    screen.fill(pygame.Color('black'))
                    pygame.display.update()
                    lancer = True
            elif event.type==pygame.VIDEORESIZE:
                largeur=event.w
                hauteur=event.h
                screen=creer_onglet(largeur_rec,hauteur_rec)
            elif event.type == pygame.KEYDOWN:
                if event.key == pygame.K_a:
                    pygame.quit()
                    exit()
                    lancer = True
    #lancement du premier niveau
    histoire1=["<<Annonce des gardiens du jeu>> ","Après de nombreuses recherches","Et de nombreuses situations mortelles","La détermination et le courage de l'aventurier","Ont été mis à rude épreuve","Son périlleux voyage touche à sa fin " , "Mais avant de se réjouir avec le trésor et les secrets", "L'aventurier doit d'abord " , "Franchir le fameux Lawsbyrinthes " ]
    histoire(screen,largeur,hauteur,histoire1,'imglaby/lvl1.png',largeur//2,hauteur//3)
    nb_laby=1
    partie = jouer_normal(largeur,hauteur,screen,10,10)
    if partie:
        # lancement du deuxième niveau
        nb_laby+=1
        histoire2=["Après avoir aisement franchi la première étape","L'aventurier se mis à chanter et crier de joie","Mais une fois la porte franchie","Son visage est devenu fermé et apeuré","Il venait de découvrir que son aventure au sein du Lawsbyrinthe","Venait seulement de commencer","Difficulté du niveau: taille augmentée"]

        histoire(screen,largeur,hauteur,histoire2,'imglaby/lvl2.png',largeur//3,hauteur//3)
        partie = jouer_normal(largeur,hauteur,screen,20,20)

    if partie:
        # lancement du troisième niveau
        nb_laby+=1
        histoire3=["Une nouvelle fois","L'aventurier se rua vers la sortie espérant voir la fin","Mais une fois devant la majestueuse Lawsdoor","Il fut surpris de voir celle-ci entièrement fermée","Après quelques minutes d'observation","Il comprit rapidement qu'une clé était nécessaire ","Sa seule solution : Chercher la clé","Difficulté du niveau : Prendre la clé"]

        histoire(screen,largeur,hauteur,histoire3,'imglaby/lvl3.png',largeur//3,hauteur//3)
        partie = jouer_cle(largeur,hauteur,screen,15,15)

    if partie:
        # lancement du quatrième niveau
        nb_laby+=1
        histoire4=["Se rapprochant de la porte avec la clé","L'aventurier était impatient de sortir de ce labyrinthe","Mais plus la distance avec la porte se réduisait,","Plus il avait l'impression d'entendre des bruits anormaux","Une fois la porte ouverte tout était clair","Les bruits étaient des rugissements d'animaux sauvages","En regardant au loin, il vit son seul espoir : une épée","Difficulté du niveau : Bete / Clé"]

        histoire(screen,largeur,hauteur,histoire4,'imglaby/lvl4.png',largeur//3,hauteur//3)
        partie = jouer_cle_bete(largeur,hauteur,screen,15,15)

    if partie:
        # lancement du cinquième niveau
        nb_laby+=1
        histoire5=["Une fois sortit du labyrinthe","L'aventurier avait l'impression d'avoir échappé de justesse à la mort ","Il commença alors à regretter sa venue ","Mais il était allé trop loin pour s'arrêter maintenant","Il se devait donc de continuer","Il vit la bête, en vie franchir le mur et rejoindre le niveau suivant","Il le compris, le pire reste à venir","Difficulté du niveau : bête X 2 / clé"]

        histoire(screen,largeur,hauteur,histoire5,'imglaby/lvl5.png',largeur//3,hauteur//3)
        partie = jouer_cle_bete2(largeur,hauteur,screen,20,20)

    if partie:
        # lancement du sixième niveau
        nb_laby+=1
        histoire6=["Apeuré par les bêtes qui le poursuivait ","L'aventurier se mis à courir afin de fuir","Mais il sentait la chaleur monter et monter","Il fit alors une pause mais sentit rapidement de la fumée","Ainsi, il le comprit ce n'était pas son corps","Le labyrinthe tout entier prenait feu ","Selon ses calculs dans 1m30 il ne sera plus qu'un tas de cendre","Difficulté du niveau : Feu/bête/clé"]

        histoire(screen,largeur,hauteur,histoire6,'imglaby/lvl6.png',largeur//3,hauteur//3)
        partie = jouer_time(largeur,hauteur,screen,20,20)

    if partie:
        # lancement du septième niveau
        nb_laby+=1
        histoire7=["Une fois de plus la mort ne s'empara pas de l'aventurier","Pour autant la fumée engendrée s'est maintenant répandue","<<Annonce des gardiens du jeu>>","En raison de l'incendie certaine mise à jour sont apportées :","La difficulté affectée au niveau 7 est désormais annulée","De plus, une lampe torche est attribuée à l'aventurier ","L'aventurier prit alors la lampe et commença le niveau","Difficulté du niveau : Fumée"]


        histoire(screen,largeur,hauteur,histoire7,'imglaby/lvl7.png',largeur//3,hauteur//3)
        partie = jouer_brouillar(largeur,hauteur,screen,17,17)
    if partie:
        # lancement du dernier niveau
        nb_laby+=1
        histoire8=["Après un long moment de recherche","L'aventurier trouva enfin la sortie et entendit ce message :","<<Annonce des gardiens du jeu>>","La fumée étant aussi présente dans le dernier niveau ","Une carte du labyrinthe est disposée à l'entrée","Pour autant aucun autre aménagement ne sera effectué","Après un court instant d'étude de la carte,la lampe s'éteignit","L'aventurier était donc plongé dans le noir","Difficulté du niveau : Aveugle"]

        histoire(screen,largeur,hauteur,histoire8,'imglaby/lvl8.png',largeur//3,hauteur//3)
        partie = jouer_invisble(largeur,hauteur,screen,12,12)


    if partie :
        # lancement de l'histoire en cas de victoire
        histoire_win(largeur,hauteur,screen)
    else:
        # lancement de l'histoire en cas de défaite
        histoire_mort(largeur,hauteur,screen,nb_laby)
    quitter=False
    while not quitter: # on attends que l'utilisateur quitte le jeu
        for event in pygame.event.get(): # récupération de tous les évenements
            if event.type ==pygame.QUIT: #cas ou on ferme la fenetre
                pygame.quit()
                exit()
                quitter = True
            elif event.type==pygame.KEYDOWN:
                if event.key == pygame.K_a:
                    pygame.quit()
                    exit()





    return None


def histoire(screen,largeur,hauteur,hist_tab,lvl,megal,megah):
    '''permet de lancer une partie de l'histoire'''
    #musique
    jingle = pygame.mixer.music.load("musiquelaby/jingle.ogg")
    pygame.mixer.music.play(1, 0)
    # ajustement de la taille de l'image et affichage
    vals=convertion(largeur,hauteur,1469,1328)
    largeurimg=vals[0]
    hauteurimg=vals[1]
    espace=vals[2]
    espaceh=vals[3]

    screen.fill(pygame.Color('white'))
    bckgrd=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/annonce.png")),(largeurimg,hauteurimg))
    screen.blit(bckgrd,(espace,espaceh))
    pygame.display.update()
    time.sleep(4)
    #musique et fond
    trailer = pygame.mixer.music.load("musiquelaby/trailer2.ogg")
    pygame.mixer.music.play(1, 0)
    afficher_elt(largeur,hauteur,'imglaby/ecran2.jpg',screen)
    pygame.display.update()


    stop = False
    liste_taille=[]
    for elt in hist_tab:
        liste_taille.append(int((largeur*2.20)/len(elt))) # Récupération taille d'écriture
    taille=min(liste_taille)
    smallfont = pygame.font.SysFont('text',taille)
    haut=hauteur*2//3-taille
    carre=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/blanc.png")),(largeur*3//4,taille))
    for elt in hist_tab: # écriture
        text=smallfont.render(elt , True , pygame.Color('black'))

        screen.blit(text , (30,haut))
        pygame.display.update()

        for event in pygame.event.get():
            if event.type ==pygame.QUIT: #cas ou on ferme la fenetre
                pygame.quit()
                exit()
            if event.type==pygame.KEYDOWN:
                if event.key == pygame.K_a:
                    pygame.quit()
                    exit()
                    stop=True
            elif event.type == pygame.KEYDOWN or event.type == pygame.MOUSEBUTTONDOWN:
                stop =True
        if not stop :
            time.sleep(2.5)

        screen.blit(carre,(10,haut))
        pygame.display.update()

    #passage de niveau
    lvl=pygame.transform.scale(pygame.image.load(os.path.join(lvl)),(largeur,hauteur))
    screen.blit(lvl,(0,0))
    pygame.display.update()
    time.sleep(3)

def jouer_normal(largeur,hauteur,screen,w,h):
    '''permet de lancer le niveay 1 et 2 du jeu
    difficulté : taille '''

    screen.fill(pygame.Color('black'))
    laby=draw_laby_start(w,h,largeur,hauteur,screen)
    #calcul des tailles importantes
    case_w=largeur//w
    case_h=hauteur//h

    taille = round(min(case_w*2/3,case_h*2/3))
    espacex=round((case_w-taille)*1/2)
    espacey=round((case_h-taille)*1/2)
    #chargement images nécessaires
    pointeur = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
    win = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/porteouverte.jpg")), (taille, taille))
    gagner = False
    #calcul coordonnées et affichage
    x =espacex
    y = espacey
    coord_joueur=(x//case_w,y//case_h)
    posxwin = largeur - espacex -taille
    posywin = hauteur - espacey -taille
    coordwin=(posxwin//case_w,posywin//case_h)
    screen.blit(pointeur, (x, y))
    screen.blit(win, (posxwin,posywin))
    pygame.display.update()
    pluiedeb = pygame.mixer.music.load("musiquelaby/pluie.ogg")
    pygame.mixer.music.play(100, 0)
    while not gagner :
        for event in pygame.event.get():  # récupération de tous les évenements
            if event.type == pygame.QUIT:  # cas ou on ferme la fenetre
                pygame.quit()
                exit()
                gagner = True
            elif event.type == pygame.KEYDOWN:
                if event.key==pygame.K_SPACE:
                    gagner=True
                elif event.key == pygame.K_a:
                    pygame.quit()
                    exit()

                #mouvement joueur
                place = move_player(event.key, x, y,w,h,largeur,hauteur,laby)
                pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                pygame.mixer.music.play(100, 5)
                xtmp=x
                ytmp=y
                coord_joueur_tmp=(xtmp//case_w,ytmp//case_h)
                x = place[0]
                y = place[1]
                coord_joueur=(x//case_w,y//case_h)
                screen.blit(pointeur, (x, y))
                if coord_joueur != coord_joueur_tmp: #suppression ancienne position
                    couvre(xtmp,ytmp,taille,taille,screen)
                if not gagner and coord_joueur_tmp==coordwin:
                    screen.blit(win, (posxwin, posywin))
                if coord_joueur==coordwin :
                    gagner = True
                pygame.display.update()
    return gagner



def jouer_cle(largeur,hauteur,screen,w,h):
    '''permet de lancer l'étape 3 du jeu
    difficulté : chercher la clé qui permet d'ouvrir la porte'''
    screen.fill(pygame.Color('black'))
    laby=draw_laby_start(w,h,largeur,hauteur,screen)
    #calcul tailles
    case_w=largeur//w
    case_h=hauteur//h

    taille = round(min(case_w*2/3,case_h*2/3))
    espacex=round((case_w-taille)*1/2)
    espacey=round((case_h-taille)*1/2)
    #chargement images
    pointeur = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
    win = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/portefermee.jpg")), (taille, taille))
    cle = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/cle.jpg")), (taille, taille))
    gagner = False

    #coordonnées et affichage
    posxwin = largeur - espacex -taille
    posywin = hauteur - espacey -taille
    coordwin=(posxwin//case_w,posywin//case_h)
    pos=laby.get_reachable_cells((coordwin[1],coordwin[0]))

    coord_joueur=choice(pos)
    coord_joueur=(coord_joueur[1],coord_joueur[0])
    x=coord_joueur[0]*case_w+espacex
    y=coord_joueur[1]*case_h+espacey
    posxcle=espacex
    posycle=hauteur-espacey-taille
    coordcle=(posxcle//case_w,posycle//case_h)
    screen.blit(pointeur, (x, y))
    screen.blit(win, (posxwin,posywin))
    screen.blit(cle, (posxcle,posycle))
    pygame.display.update()
    pluiedeb = pygame.mixer.music.load("musiquelaby/pluie.ogg")
    pygame.mixer.music.play(100, 0)
    possede_cle = False
    while not gagner :
        act=False
        for event in pygame.event.get():  # récupération de tous les évenements
            if event.type == pygame.QUIT:  # cas ou on ferme la fenetre
                pygame.quit()
                exit()
                gagner = True
            elif event.type == pygame.KEYDOWN:
                if event.key==pygame.K_SPACE:
                    gagner=True
                elif event.key == pygame.K_a:
                    pygame.quit()
                    exit()
                #mouvement joueur
                place = move_player(event.key, x, y,w,h,largeur,hauteur,laby)
                pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                pygame.mixer.music.play(100, 5)
                xtmp=x
                ytmp=y
                coord_joueur_tmp=(xtmp//case_w,ytmp//case_h)
                x = place[0]
                y = place[1]
                coord_joueur=(x//case_w,y//case_h)
                screen.blit(pointeur, (x, y))
                if coord_joueur != coord_joueur_tmp: #suppression ancienne position
                    couvre(xtmp,ytmp,taille,taille,screen)
                if not gagner and coord_joueur_tmp==coordwin:
                    screen.blit(win, (posxwin, posywin))
                if coord_joueur==coordwin and possede_cle:
                    gagner = True
                if coordcle==coord_joueur and not(possede_cle): # récupération clé
                    possede_cle = True
                    porte = pygame.mixer.music.load("musiquelaby/porte.ogg")

                    pygame.mixer.music.play(1, 1)
                    afficher_elt(largeur,hauteur,'imglaby/lvl1cle.jfif',screen)
                    pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                    pygame.mixer.music.play(100, 5)
                    act=True
                if possede_cle and act: # modification totale du labyrinthe
                    laby=draw_laby_start(w,h,largeur,hauteur,screen)
                    win=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/porteouverte.jpg")), (taille, taille))
                if act: # affichage suite à récupération clé
                    screen.fill(pygame.Color('black'))
                    draw_laby_from_walls(laby,h,w,largeur,hauteur,screen)
                    screen.blit(pointeur, (x, y))
                    if not possede_cle:
                        screen.blit(cle, (posxcle, posycle))
                    screen.blit(win, (posxwin, posywin))
                pygame.display.update()
    return gagner








def jouer_cle_bete(largeur,hauteur,screen,w,h):
    '''permet de lancer le jeu niveau 4
    difficulte : bete : mort en cas de rencontre sans épée '''
    pouv=choice_bonus(largeur,hauteur,screen,4) # récupération pouvoir
    if pouv == 'vie':
        res=True
    else:
        res=False
    screen.fill(pygame.Color('black'))
    laby=draw_laby_start(w,h,largeur,hauteur,screen)
    #calcul tailles
    case_w=largeur//w
    case_h=hauteur//h

    taille = round(min(case_w*2/3,case_h*2/3))
    espacex=round((case_w-taille)*1/2)
    espacey=round((case_h-taille)*1/2)
    #chargement images
    pointeur = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
    win = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/portefermee.jpg")), (taille, taille))
    bete = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/lion.jpg")), (taille, taille))
    epee = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/épée.jpg")), (taille, taille))
    cle = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/cle.jpg")), (taille, taille))
    gagner = False
    perdu = False

    x =espacex
    y = espacey
    coord_joueur=(x//case_w,y//case_h)
    # coordonnées et affichage du poointeur du trophée et de la bete

    posxwin = largeur - espacex -taille
    posywin = hauteur - espacey -taille
    coordwin=(posxwin//case_w,posywin//case_h)

    posxbete = w//2*case_w+espacex
    posybete = h//2*case_h +espacey
    coordbete=(posxbete//case_w,posybete//case_h)
    posxepee = largeur-espacex-taille
    posyepee =espacey
    coordepee=(posxepee//case_w,posyepee//case_h)
    posxcle=espacex
    posycle=hauteur-espacey-taille
    coordcle=(posxcle//case_w,posycle//case_h)
    screen.blit(pointeur, (x, y))
    screen.blit(win, (posxwin,posywin))
    screen.blit(bete, (posxbete,posybete))
    screen.blit(epee, (posxepee,posyepee))
    screen.blit(cle, (posxcle,posycle))
    pygame.display.update()
    possede_epee = False
    bete_vie = True
    possede_cle = False
    pluiedeb = pygame.mixer.music.load("musiquelaby/pluie.ogg")
    pygame.mixer.music.play(100, 0)
    reste_pouv=True

    while not gagner and not perdu:
        for event in pygame.event.get():  # récupération de tous les évenements
            if event.type == pygame.QUIT:  # cas ou on ferme la fenetre
                pygame.quit()
                exit()
                gagner = True
            elif event.type == pygame.KEYDOWN:
                if event.key==pygame.K_r and reste_pouv: # utilisation d'un pouvoir actif

                    if pouv=='destru':
                        act=True
                        reste_pouv=False
                        affiche_destru(largeur,hauteur,coord_joueur,laby,screen)
                        laby=destru_wall(laby,coord_joueur)
                    elif pouv=='tp':
                        act=True
                        reste_pouv=False
                        new_coord=teleportation(laby,w,h,[coordbete,coordcle,coordepee,coordwin],case_w,case_h,espacex,espacey)
                        coord_joueur=new_coord[0]
                        x=new_coord[1]
                        y=new_coord[2]
                    elif pouv=='tremblement':
                        laby=draw_laby_start(h,w,largeur,hauteur,screen)
                        act=True
                        reste_pouv=False
                    elif pouv == 'indice':
                        reste_pouv=False
                        act=True
                        indice(laby,w,h,case_w,case_h,espacex,espacey,taille,coordcle,possede_cle,coordwin,coord_joueur,screen)



                else :
                    if event.key==pygame.K_SPACE:
                        gagner=True
                    elif event.key == pygame.K_a:
                        pygame.quit()
                        exit()
                    #mouvement joueur
                    place = move_player(event.key, x, y,w,h,largeur,hauteur,laby)
                    xtmp=x
                    ytmp=y
                    pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                    pygame.mixer.music.play(100, 5)
                    coord_joueur_tmp=(xtmp//case_w,ytmp//case_h)
                    x = place[0]
                    y = place[1]
                    coord_joueur=(x//case_w,y//case_h)

                    act=False
                    screen.blit(pointeur, (x, y))

                    couvre(xtmp,ytmp,taille,taille,screen)
                    if not gagner and coord_joueur_tmp==coordwin:
                        screen.blit(win, (posxwin, posywin))


                    if bete_vie: #mouvement bete

                        place_bete = move_bete_smart(posxbete, posybete,w,h,espacex,espacey,laby,largeur,hauteur,coord_joueur,coordcle,coordwin,coordepee,coordbete)
                        x1tmp=posxbete
                        y1tmp=posybete
                        posxbete = place_bete[0]
                        posybete = place_bete[1]
                        coordbete=(posxbete//case_w,posybete//case_h)
                        coordtmp=(x1tmp//case_w,y1tmp//case_h)



                        couvre(x1tmp,y1tmp,taille,taille,screen)
                    screen.blit(pointeur, (x, y))




                    if coordepee==coord_joueur and not(possede_epee): # récupération épée
                        coordepee=(-15,-15)
                        possede_epee = True
                        ep = pygame.mixer.music.load("musiquelaby/epee.ogg")
                        pygame.mixer.music.play(1, 0)
                        afficher_elt(largeur,hauteur,'imglaby/sorsepee.webp',screen)
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        act=True

                    if coordcle==coord_joueur and not(possede_cle): # récupération clé
                        coordcle=(-15,-15)
                        possede_cle = True
                        porte = pygame.mixer.music.load("musiquelaby/porte.ogg")

                        pygame.mixer.music.play(1, 1)
                        afficher_elt(largeur,hauteur,'imglaby/lvl1cle.jfif',screen)
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        act=True
                    if possede_epee and act: # transformation en guerrier
                        pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/guerrier.jpg")),(taille, taille))
                    if possede_cle and act: # ouverture porte
                        win=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/porteouverte.jpg")), (taille, taille))

                    if coord_joueur in (coordbete,coordtmp) and coordbete in (coord_joueur,coord_joueur_tmp) and not possede_epee: # rencontre avec bete sans épée
                        if not res: # si on n'a pas le pouvoir resurection
                            perdu = True
                            rugissement = pygame.mixer.music.load("musiquelaby/rugi.ogg")
                            pygame.mixer.music.play(1, 0)

                            afficher_elt(largeur,hauteur,'imglaby/rugissement.jfif',screen)
                        else:
                            res=False
                            afficher_elt(largeur,hauteur,'imglaby/brise.jpg',screen)
                            act=True
                            new_coord=teleportation(laby,w,h,[coordbete,coordcle,coordepee,coordwin,coord_joueur],case_w,case_h,espacex,espacey)
                            coordbete=new_coord[0]
                            posxbete=new_coord[1]
                            posybete=new_coord[2]

                    if coord_joueur in (coordbete,coordtmp) and coordbete in (coord_joueur,coord_joueur_tmp) and possede_epee and bete_vie: # rencontre bete avec épée
                        bete_vie = False
                        possede_epee=False
                        pointeur = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
                        cri = pygame.mixer.music.load("musiquelaby/cri.ogg")
                        pygame.mixer.music.play(1, 0)
                        afficher_elt(largeur,hauteur,'imglaby/victorieux.jpg',screen)
                        act=True
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        posxbete=-15
                        posybete=-15
                        coordbete=(-15,-15)
                        couvre(x,y,taille,taille,screen)

                    if coord_joueur==coordwin and possede_cle:
                        gagner = True

                    if bete_vie :
                        screen.blit(bete, (posxbete, posybete))

                if act: # affichage suite à récupération objet ou rencontre
                    screen.fill(pygame.Color('black'))
                    draw_laby_from_walls(laby,h,w,largeur,hauteur,screen)
                    screen.blit(pointeur, (x, y))
                    if not possede_cle:
                        screen.blit(cle, (posxcle, posycle))
                    if bete_vie:
                        screen.blit(bete, (posxbete, posybete))
                    if not possede_epee and (bete_vie):
                        screen.blit(epee, (posxepee, posyepee))
                    screen.blit(win, (posxwin, posywin))






                pygame.display.update()
    return gagner

def jouer_cle_bete2(largeur,hauteur,screen,w,h):
    '''permet de lancer le jeu niveau 5
    difficulte : bete *2 : mort en cas de rencontre sans épée '''
    pouv=choice_bonus(largeur,hauteur,screen,5) # récupération pouvoir
    if pouv == 'vie':
        res=True
    else:
        res=False

    screen.fill(pygame.Color('black'))
    laby=draw_laby_start(w,h,largeur,hauteur,screen)
    # calcul tailles
    case_w=largeur//w
    case_h=hauteur//h
    taille = round(min(case_w*2/3,case_h*2/3))
    espacex=round((case_w-taille)*1/2)
    espacey=round((case_h-taille)*1/2)


    # chargement images
    pointeur = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
    win = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/portefermee.jpg")), (taille, taille))
    bete = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/lion.jpg")), (taille, taille))
    bete1 = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/lion.jpg")), (taille, taille))
    epee = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/épée.jpg")), (taille, taille))
    cle = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/cle.jpg")), (taille, taille))
    gagner = False
    perdu = False

    x =espacex
    y = espacey
    coord_joueur=(x//case_w,y//case_h)
    # calcul coordonnées et affichage du pointeur du trophée et des betes

    posxwin = largeur - espacex -taille
    posywin = hauteur - espacey -taille
    coordwin=(posxwin//case_w,posywin//case_h)

    posxbete = w//4*case_w+espacex
    posybete = h//2*case_h +espacey
    coordbete=(posxbete//case_w,posybete//case_h)

    posxbete1 = int(w*3/4)*case_w+espacex
    posybete1 = h//2*case_h +espacey
    coordbete1=(posxbete1//case_w,posybete1//case_h)


    posxepee = largeur-espacex-taille
    posyepee =espacey
    coordepee=(posxepee//case_w,posyepee//case_h)
    posxcle=espacex
    posycle=hauteur-espacey-taille
    coordcle=(posxcle//case_w,posycle//case_h)
    screen.blit(pointeur, (x, y))
    screen.blit(win, (posxwin,posywin))
    screen.blit(bete, (posxbete,posybete))
    screen.blit(bete1, (posxbete1,posybete1))
    screen.blit(epee, (posxepee,posyepee))
    screen.blit(cle, (posxcle,posycle))
    pygame.display.update()
    possede_epee = False
    bete_vie = True
    bete1_vie = True
    possede_cle = False
    reste_pouv=True
    pluiedeb = pygame.mixer.music.load("musiquelaby/pluie.ogg")
    pygame.mixer.music.play(100, 0)
    nb_bete_tue=0
    while not gagner and not perdu:

        for event in pygame.event.get():  # récupération de tous les évenements
            if event.type == pygame.QUIT:  # cas ou on ferme la fenetre
                pygame.quit()
                exit()
                gagner = True
            elif event.type == pygame.KEYDOWN:
                if event.key==pygame.K_r and reste_pouv: # activation pouvoir actif

                    if pouv=='destru':
                        act=True
                        reste_pouv=False
                        affiche_destru(largeur,hauteur,coord_joueur,laby,screen)
                        laby=destru_wall(laby,coord_joueur)
                    elif pouv=='tp':
                        act=True
                        reste_pouv=False
                        new_coord=teleportation(laby,w,h,[coordbete,coordbete1,coordcle,coordepee,coordwin],case_w,case_h,espacex,espacey)
                        coord_joueur=new_coord[0]
                        x=new_coord[1]
                        y=new_coord[2]
                    elif pouv=='tremblement':
                        laby=draw_laby_start(h,w,largeur,hauteur,screen)
                        act=True
                        reste_pouv=False

                    elif pouv == 'indice':
                        reste_pouv=False
                        act=True
                        indice(laby,w,h,case_w,case_h,espacex,espacey,taille,coordcle,possede_cle,coordwin,coord_joueur,screen)
                else:
                    if event.key==pygame.K_SPACE:
                        gagner=True
                    elif event.key == pygame.K_a:
                        pygame.quit()
                        exit()
                    #mouvement joueur
                    place = move_player(event.key, x, y,w,h,largeur,hauteur,laby)
                    xtmp=x
                    ytmp=y
                    pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                    pygame.mixer.music.play(100, 5)
                    coord_joueur_tmp=(xtmp//case_w,ytmp//case_h)
                    x = place[0]
                    y = place[1]
                    coord_joueur=(x//case_w,y//case_h)

                    act=False
                    screen.blit(pointeur, (x, y))

                    couvre(xtmp,ytmp,taille,taille,screen)
                    if not gagner and coord_joueur_tmp==coordwin:
                        screen.blit(win, (posxwin, posywin))


                    if bete_vie: # mouvement bete

                        place_bete = move_bete_smart(posxbete, posybete,w,h,espacex,espacey,laby,largeur,hauteur,coord_joueur,coordcle,coordwin,coordepee,coordbete,coordbete1)
                        x1tmp=posxbete
                        y1tmp=posybete
                        posxbete = place_bete[0]
                        posybete = place_bete[1]
                        coordbete=(posxbete//case_w,posybete//case_h)
                        coordtmp=(x1tmp//case_w,y1tmp//case_h)




                        couvre(x1tmp,y1tmp,taille,taille,screen)

                    if bete1_vie: # mouvement bete1


                        place_bete1 = move_bete_smart(posxbete1, posybete1,w,h,espacex,espacey,laby,largeur,hauteur,coord_joueur,coordcle,coordwin,coordepee,coordbete1,coordbete)
                        x2tmp=posxbete1
                        y2tmp=posybete1
                        posxbete1 = place_bete1[0]
                        posybete1 = place_bete1[1]
                        coordbete1=(posxbete1//case_w,posybete1//case_h)
                        coordtmp2=(x2tmp//case_w,y2tmp//case_h)



                        couvre(x2tmp,y2tmp,taille,taille,screen)
                    screen.blit(pointeur, (x, y))




                    if coordepee==coord_joueur and not(possede_epee): # récupération épée

                        possede_epee = True
                        ep = pygame.mixer.music.load("musiquelaby/epee.ogg")
                        pygame.mixer.music.play(1, 0)
                        afficher_elt(largeur,hauteur,'imglaby/sorsepee.webp',screen)
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        act=True
                        coordepee=(-15,-15)

                    if coordcle==coord_joueur and not(possede_cle): # récupération clé
                        coordcle=(-15,-15)
                        possede_cle = True
                        porte = pygame.mixer.music.load("musiquelaby/porte.ogg")

                        pygame.mixer.music.play(1, 1)
                        afficher_elt(largeur,hauteur,'imglaby/lvl1cle.jfif',screen)
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        act=True
                    if possede_epee and act: # transformation en guerrier
                        pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/guerrier.jpg")),(taille, taille))
                    if possede_cle and act: # ouverture de la porte
                        win=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/porteouverte.jpg")), (taille, taille))

                    if coord_joueur in (coordbete,coordtmp) and coordbete in (coord_joueur,coord_joueur_tmp) and not possede_epee and bete_vie: # rencontre avec bete sans épée
                        if not res: # si pas pouvoir resurection
                            perdu = True
                            rugissement = pygame.mixer.music.load("musiquelaby/rugi.ogg")
                            pygame.mixer.music.play(1, 0)

                            afficher_elt(largeur,hauteur,'imglaby/rugissement.jfif',screen)
                            pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                            pygame.mixer.music.play(100, 5)
                        else:
                            res=False
                            afficher_elt(largeur,hauteur,'imglaby/brise.jpg',screen)
                            act=True
                            new_coord=teleportation(laby,w,h,[coordbete,coordbete1,coordcle,coordepee,coordwin,coord_joueur],case_w,case_h,espacex,espacey)
                            coordbete=new_coord[0]
                            posxbete=new_coord[1]
                            posybete=new_coord[2]

                    if coord_joueur in (coordbete,coordtmp) and coordbete in (coord_joueur,coord_joueur_tmp) and possede_epee and bete_vie : # rencontre bete avec épée
                        bete_vie = False
                        cri = pygame.mixer.music.load("musiquelaby/cri.ogg")
                        pygame.mixer.music.play(1, 0)
                        afficher_elt(largeur,hauteur,'imglaby/victorieux.jpg',screen)
                        act=True
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        posxbete=-15
                        posybete=-15
                        coordbete=(posxbete//case_w,posybete//case_h)
                        couvre(x,y,taille,taille,screen)
                        nb_bete_tue+=1
                        if nb_bete_tue==1: # transformation en homme + nouvelle épée emplacement aléatoire
                            possede_epee=False
                            pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
                            new_coord=teleportation(laby,w,h,[coord_joueur,coordbete,coordbete1,coordcle,coordepee,coordwin],case_w,case_h,espacex,espacey)
                            coordepee=new_coord[0]
                            posxepee=new_coord[1]
                            posyepee=new_coord[2]
                            screen.blit(epee, (posxepee, posyepee))
                        else:
                            possede_epee=False
                            pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
                            coordepee=(-15,-15)


                    if coord_joueur in (coordbete1,coordtmp2) and coordbete1 in (coord_joueur,coord_joueur_tmp) and not possede_epee and bete1_vie: # rencontre bete1 sans épée
                        if not res: # si on a pas le pouvoir resurection
                            perdu = True
                            rugissement = pygame.mixer.music.load("musiquelaby/rugi.ogg")
                            pygame.mixer.music.play(1, 0)

                            afficher_elt(largeur,hauteur,'imglaby/rugissement.jfif',screen)
                        else:
                            res=False
                            afficher_elt(largeur,hauteur,'imglaby/brise.jpg',screen)
                            act=True
                            new_coord=teleportation(laby,w,h,[coordbete,coordbete1,coordcle,coordepee,coordwin,coord_joueur],case_w,case_h,espacex,espacey)
                            coordbete1=new_coord[0]
                            posxbete1=new_coord[1]
                            posybete1=new_coord[2]

                    if coord_joueur in (coordbete1,coordtmp2) and coordbete1 in (coord_joueur,coord_joueur_tmp) and possede_epee and bete1_vie: # rencontre bete1 avec épée
                        bete1_vie = False
                        cri = pygame.mixer.music.load("musiquelaby/cri.ogg")
                        pygame.mixer.music.play(1, 0)
                        afficher_elt(largeur,hauteur,'imglaby/victorieux.jpg',screen)
                        act=True
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        posxbete1=-15
                        posybete1=-15
                        coordbete1=(posxbete1//case_w,posybete1//case_h)
                        couvre(x,y,taille,taille,screen)
                        nb_bete_tue+=1
                        if nb_bete_tue==1: # transformarion en homme + nouvelle épée
                            possede_epee=False
                            pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
                            new_coord=teleportation(laby,w,h,[coord_joueur,coordbete,coordbete1,coordcle,coordepee,coordwin],case_w,case_h,espacex,espacey)
                            coordepee=new_coord[0]
                            posxepee=new_coord[1]
                            posyepee=new_coord[2]
                            screen.blit(epee, (posxepee, posyepee))
                        else:
                            pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
                            coordepee=(-15,-15)
                            possede_epee=False


                    if coord_joueur==coordwin and possede_cle:
                        gagner = True

                    if bete_vie :
                        screen.blit(bete, (posxbete, posybete))
                    if bete1_vie :
                        screen.blit(bete1, (posxbete1, posybete1))
                if act: # affichage suite à récupération objet ou rencontre
                    screen.fill(pygame.Color('black'))
                    draw_laby_from_walls(laby,h,w,largeur,hauteur,screen)
                    screen.blit(pointeur, (x, y))
                    if not possede_cle  :
                        screen.blit(cle, (posxcle, posycle))
                    if bete_vie:
                        screen.blit(bete, (posxbete, posybete))
                    if bete1_vie:
                        screen.blit(bete1, (posxbete1, posybete1))
                    if not possede_epee and (bete_vie or bete1_vie):
                        screen.blit(epee, (posxepee, posyepee))
                    screen.blit(win, (posxwin, posywin))






                pygame.display.update()
    return gagner


def jouer_time(largeur,hauteur,screen,w,h):
    '''permet de lancer le jeu niveau 6
    difficulte : bete *2  : mort en cas de rencontre sans épée + temps limite : 1m30'''
    pouv=choice_bonus(largeur,hauteur,screen,6) # récupération pouvoir
    if pouv == 'vie':
        res=True
    else:
        res=False

    screen.fill(pygame.Color('black'))
    laby=draw_laby_start(w,h,largeur,hauteur,screen)
    #calcul tailles
    case_w=largeur//w
    case_h=hauteur//h

    taille = round(min(case_w*2/3,case_h*2/3))
    espacex=round((case_w-taille)*1/2)
    espacey=round((case_h-taille)*1/2)

    #chargement images
    pointeur = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
    win = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/portefermee.jpg")), (taille, taille))
    bete = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/lion.jpg")), (taille, taille))
    bete1 = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/lion.jpg")), (taille, taille))
    epee = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/épée.jpg")), (taille, taille))
    cle = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/cle.jpg")), (taille, taille))

    gagner = False
    perdu = False

    x =espacex
    y = espacey
    coord_joueur=(x//case_w,y//case_h)
    # coordonnées + affichage du poointeur du trophée et de la bete

    posxwin = largeur - espacex -taille
    posywin = hauteur - espacey -taille
    coordwin=(posxwin//case_w,posywin//case_h)

    posxbete = w//4*case_w+espacex
    posybete = h//2*case_h +espacey
    coordbete=(posxbete//case_w,posybete//case_h)

    posxbete1 = int(w*3/4)*case_w+espacex
    posybete1 = h//2*case_h +espacey
    coordbete1=(posxbete1//case_w,posybete1//case_h)


    posxepee = largeur-espacex-taille
    posyepee =espacey
    coordepee=(posxepee//case_w,posyepee//case_h)
    posxcle=espacex
    posycle=hauteur-espacey-taille
    coordcle=(posxcle//case_w,posycle//case_h)
    screen.blit(pointeur, (x, y))
    screen.blit(win, (posxwin,posywin))
    screen.blit(bete, (posxbete,posybete))
    screen.blit(bete1, (posxbete1,posybete1))
    screen.blit(epee, (posxepee,posyepee))
    screen.blit(cle, (posxcle,posycle))
    pygame.display.update()
    possede_epee = False
    bete_vie = True
    bete1_vie = True
    possede_cle = False
    pluiedeb = pygame.mixer.music.load("musiquelaby/feu.ogg")
    pygame.mixer.music.play(100, 0)
    # calcul des temps
    temps=time.time()
    temps_30=temps+30
    temps_60=temps+60
    temps_max=temps+90
    taille_flammes=12
    fait_30=False
    fait_60 = False
    reste_pouv=True
    nb_bete_tue=0
    afficher_flammes(case_w,case_h,w,h,screen,taille_flammes)
    act=False
    while not gagner and not perdu:

        for event in pygame.event.get():  # récupération de tous les évenements
            if event.type == pygame.QUIT:  # cas ou on ferme la fenetre
                pygame.quit()
                exit()
                gagner = True
            elif event.type == pygame.KEYDOWN:
                if event.key==pygame.K_r and reste_pouv: # activation pouvoir actif

                    if pouv=='destru':
                        act=True
                        reste_pouv=False
                        affiche_destru(largeur,hauteur,coord_joueur,laby,screen)
                        laby=destru_wall(laby,coord_joueur)
                    elif pouv=='tp':
                        act=True
                        reste_pouv=False
                        new_coord=teleportation(laby,w,h,[coordbete,coordbete1,coordcle,coordepee,coordwin],case_w,case_h,espacex,espacey)
                        coord_joueur=new_coord[0]
                        x=new_coord[1]
                        y=new_coord[2]
                    elif pouv=='tremblement':
                        laby=draw_laby_start(h,w,largeur,hauteur,screen)
                        act=True
                        reste_pouv=False

                    elif pouv == 'indice':
                        reste_pouv=False
                        act=True
                        indice(laby,w,h,case_w,case_h,espacex,espacey,taille,coordcle,possede_cle,coordwin,coord_joueur,screen)
                else:

                    if event.key==pygame.K_SPACE:
                        gagner=True
                    elif event.key == pygame.K_a:
                        pygame.quit()
                        exit()

                    #mouvement joueur
                    place = move_player(event.key, x, y,w,h,largeur,hauteur,laby)
                    xtmp=x
                    ytmp=y
                    pluie = pygame.mixer.music.load("musiquelaby/feu.ogg")
                    pygame.mixer.music.play(100, 5)
                    coord_joueur_tmp=(xtmp//case_w,ytmp//case_h)
                    x = place[0]
                    y = place[1]
                    coord_joueur=(x//case_w,y//case_h)

                    act=False
                    screen.blit(pointeur, (x, y))

                    couvre(xtmp,ytmp,taille,taille,screen)
                    if not gagner and coord_joueur_tmp==coordwin:
                        screen.blit(win, (posxwin, posywin))


                    if bete_vie: #mouvement bete

                        place_bete = move_bete_smart(posxbete, posybete,w,h,espacex,espacey,laby,largeur,hauteur,coord_joueur,coordcle,coordwin,coordepee,coordbete,coordbete1)
                        x1tmp=posxbete
                        y1tmp=posybete
                        posxbete = place_bete[0]
                        posybete = place_bete[1]
                        coordbete=(posxbete//case_w,posybete//case_h)
                        coordtmp=(x1tmp//case_w,y1tmp//case_h)




                        couvre(x1tmp,y1tmp,taille,taille,screen)

                    if bete1_vie: # mouvement bete1


                        place_bete1 = move_bete_smart(posxbete1, posybete1,w,h,espacex,espacey,laby,largeur,hauteur,coord_joueur,coordcle,coordwin,coordepee,coordbete1,coordbete)
                        x2tmp=posxbete1
                        y2tmp=posybete1
                        posxbete1 = place_bete1[0]
                        posybete1 = place_bete1[1]
                        coordbete1=(posxbete1//case_w,posybete1//case_h)
                        coordtmp2=(x2tmp//case_w,y2tmp//case_h)



                        couvre(x2tmp,y2tmp,taille,taille,screen)
                    screen.blit(pointeur, (x, y))




                    if coordepee==coord_joueur and not(possede_epee): # récupération épée

                        possede_epee = True
                        coordepee=(-15,-15)
                        ep = pygame.mixer.music.load("musiquelaby/epee.ogg")
                        pygame.mixer.music.play(1, 0)
                        afficher_elt(largeur,hauteur,'imglaby/sorsepee.webp',screen)
                        pluie = pygame.mixer.music.load("musiquelaby/feu.ogg")
                        pygame.mixer.music.play(100, 5)
                        act=True

                    if coordcle==coord_joueur and not(possede_cle): # récupération clé
                        possede_cle = True
                        coordcle=(-15,-15)
                        porte = pygame.mixer.music.load("musiquelaby/porte.ogg")

                        pygame.mixer.music.play(1, 1)
                        afficher_elt(largeur,hauteur,'imglaby/lvl1cle.jfif',screen)
                        pluie = pygame.mixer.music.load("musiquelaby/feu.ogg")
                        pygame.mixer.music.play(100, 5)
                        act=True
                    if possede_epee and act:
                        pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/guerrier.jpg")),(taille, taille))
                    if possede_cle and act:
                        win=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/porteouverte.jpg")), (taille, taille))

                    if coord_joueur in (coordbete,coordtmp) and coordbete in (coord_joueur,coord_joueur_tmp) and not possede_epee and bete_vie: # rencontre bete sans épée
                        if not res: # pas pouvoir resurection
                            perdu = True
                            rugissement = pygame.mixer.music.load("musiquelaby/rugi.ogg")
                            pygame.mixer.music.play(1, 0)

                            afficher_elt(largeur,hauteur,'imglaby/rugissement.jfif',screen)
                            pluie = pygame.mixer.music.load("musiquelaby/feu.ogg")
                            pygame.mixer.music.play(100, 5)
                        else:
                            res=False
                            afficher_elt(largeur,hauteur,'imglaby/brise.jpg',screen)
                            act=True
                            new_coord=teleportation(laby,w,h,[coordbete,coordbete1,coordcle,coordepee,coordwin,coord_joueur],case_w,case_h,espacex,espacey)
                            coordbete=new_coord[0]
                            posxbete=new_coord[1]
                            posybete=new_coord[2]
                    if coord_joueur in (coordbete,coordtmp) and coordbete in (coord_joueur,coord_joueur_tmp) and possede_epee and bete_vie: # rencontre bete avec épée
                        bete_vie = False
                        cri = pygame.mixer.music.load("musiquelaby/cri.ogg")
                        pygame.mixer.music.play(1, 0)
                        afficher_elt(largeur,hauteur,'imglaby/victorieux.jpg',screen)
                        act=True
                        pluie = pygame.mixer.music.load("musiquelaby/feu.ogg")
                        pygame.mixer.music.play(100, 5)
                        posxbete=-15
                        posybete=-15
                        couvre(x,y,taille,taille,screen)
                        nb_bete_tue+=1
                        coordbete=(-15,-15)
                        if nb_bete_tue==1:
                            possede_epee=False
                            pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
                            new_coord=teleportation(laby,w,h,[coord_joueur,coordbete,coordbete1,coordcle,coordepee,coordwin],case_w,case_h,espacex,espacey)
                            coordepee=new_coord[0]
                            posxepee=new_coord[1]
                            posyepee=new_coord[2]
                        else:
                            coordepee=(-15,-15)
                            pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
                            possede_epee=False

                    if coord_joueur in (coordbete1,coordtmp2) and coordbete1 in (coord_joueur,coord_joueur_tmp) and not possede_epee and bete1_vie: # rencontre bete1 sans épée
                        if not res: # pas pouvoir resurection
                            perdu = True
                            rugissement = pygame.mixer.music.load("musiquelaby/rugi.ogg")
                            pygame.mixer.music.play(1, 0)

                            afficher_elt(largeur,hauteur,'imglaby/rugissement.jfif',screen)
                        else:
                            res=False
                            afficher_elt(largeur,hauteur,'imglaby/brise.jpg',screen)
                            act=True
                            new_coord=teleportation(laby,w,h,[coordbete,coordbete1,coordcle,coordepee,coordwin,coord_joueur],case_w,case_h,espacex,espacey)
                            coordbete1=new_coord[0]
                            posxbete1=new_coord[1]
                            posybete1=new_coord[2]

                    if coord_joueur in (coordbete1,coordtmp2) and coordbete1 in (coord_joueur,coord_joueur_tmp) and possede_epee and bete1_vie: # rencontre bete1 avec épée
                        bete1_vie = False
                        cri = pygame.mixer.music.load("musiquelaby/cri.ogg")
                        pygame.mixer.music.play(1, 0)
                        afficher_elt(largeur,hauteur,'imglaby/victorieux.jpg',screen)
                        act=True
                        pluie = pygame.mixer.music.load("musiquelaby/feu.ogg")
                        pygame.mixer.music.play(100, 5)
                        posxbete1=-15
                        posybete1=-15
                        coordbete1=(-15,-15)
                        couvre(x,y,taille,taille,screen)
                        nb_bete_tue+=1
                        if nb_bete_tue==1:
                            possede_epee=False
                            pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
                            new_coord=teleportation(laby,w,h,[coord_joueur,coordbete,coordbete1,coordcle,coordepee,coordwin],case_w,case_h,espacex,espacey)
                            coordepee=new_coord[0]
                            posxepee=new_coord[1]
                            posyepee=new_coord[2]
                        else:
                            coordepee=(-15,-15)
                            pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
                            possede_epee=False


                    if coord_joueur==coordwin and possede_cle:
                        gagner = True

                    if bete_vie :
                        screen.blit(bete, (posxbete, posybete))
                    if bete1_vie :
                        screen.blit(bete1, (posxbete1, posybete1))
                if act: # affichage suite à récupération ou rencontre

                    screen.fill(pygame.Color('black'))
                    draw_laby_from_walls(laby,h,w,largeur,hauteur,screen)
                    screen.blit(pointeur, (x, y))
                    if not possede_cle:
                        screen.blit(cle, (posxcle, posycle))
                    if bete_vie:
                        screen.blit(bete, (posxbete, posybete))
                    if bete1_vie:
                        screen.blit(bete1, (posxbete1, posybete1))
                    if not possede_epee and (bete_vie or bete1_vie):
                        screen.blit(epee, (posxepee, posyepee))
                    screen.blit(win, (posxwin, posywin))
                    temps_max+=2



        temps_act=time.time()
        # affichage des flammes en fonction du temps restant
        if act and temps_act<temps_30:
            afficher_flammes(case_w,case_h,w,h,screen,taille_flammes)

        if temps_act>=temps_30 and temps_act<temps_60 and (not fait_30 or act):
            fait_30=True
            taille_flammes=20
            afficher_flammes(case_w,case_h,w,h,screen,taille_flammes)
        if temps_act>=temps_60 and temps_act<temps_max and (not fait_60 or act) :
            fait_60=True
            taille_flammes=28
            afficher_flammes(case_w,case_h,w,h,screen,taille_flammes)


        if temps_act>temps_max:
            perdu=True
            afficher_elt(largeur,hauteur,'imglaby/flamme.jfif',screen)



        pygame.display.update()
    return gagner

def jouer_brouillar(largeur,hauteur,screen,w,h):
    '''lance le niveau 7 du jeu
    difficulté : brouillar : visibilité réduite à 2 cases '''
    pouv=choice_bonus(largeur,hauteur,screen,7)
    screen.fill(pygame.Color('black'))
    laby = draw_laby_start(h, w, largeur, hauteur, screen)

    #calcul tailles
    case_w = largeur // w
    case_h = hauteur // h

    taille = round(min(case_w * 2 / 3, case_h * 2 / 3))
    espacex = round((case_w - taille) * 1 / 2)
    espacey = round((case_h - taille) * 1 / 2)
    #chargement images
    pointeur = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")), (taille, taille))
    win = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/portefermee.jpg")), (taille, taille))
    cle = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/cle.jpg")), (taille, taille))
    gagner = False

    x = espacex
    y = espacey
    coord_joueur = (x // case_w, y // case_h)


    screen.fill(pygame.Color('black'))
    draw_laby_from_walls_brouillar(laby,h,w,largeur,hauteur,screen,coord_joueur,2)
    #coordonnées + affichage
    posxwin = largeur - espacex - taille
    posywin = hauteur - espacey - taille
    coordwin = (posxwin // case_w, posywin // case_h)
    posxcle=espacex
    posycle=hauteur-espacey-taille
    coordcle=(posxcle//case_w,posycle//case_h)
    screen.blit(pointeur, (x, y))

    pygame.display.update()
    pluiedeb = pygame.mixer.music.load("musiquelaby/pluie.ogg")
    pygame.mixer.music.play(100, 0)
    possede_cle=False
    act=False
    reste_pouv=True
    while not gagner:
        for event in pygame.event.get():  # récupération de tous les évenements
            if event.type == pygame.QUIT:  # cas ou on ferme la fenetre
                pygame.quit()
                exit()
                gagner = True
            elif event.type == pygame.KEYDOWN:
                if event.key==pygame.K_r and reste_pouv: # activation pouvoir actif

                    if pouv=='destru':
                        act=True
                        reste_pouv=False
                        affiche_destru(largeur,hauteur,coord_joueur,laby,screen)
                        laby=destru_wall(laby,coord_joueur)

                    elif pouv=='tp':
                        act=True
                        reste_pouv=False
                        new_coord=teleportation(laby,w,h,[coordcle,coordwin],case_w,case_h,espacex,espacey)
                        coord_joueur=new_coord[0]
                        x=new_coord[1]
                        y=new_coord[2]
                    elif pouv=='tremblement':
                        laby=draw_laby_start(h,w,largeur,hauteur,screen)
                        act=True
                        reste_pouv=False
                    elif pouv=='vision':
                        act=True
                        reste_pouv=False
                        screen.fill(pygame.Color('black'))
                        draw_laby_from_walls(laby,h,w,largeur,hauteur,screen)
                        time.sleep(5)


                    elif pouv == 'indice':
                        reste_pouv=False
                        act=True
                        indice(laby,w,h,case_w,case_h,espacex,espacey,taille,coordcle,possede_cle,coordwin,coord_joueur,screen)

                    draw_laby_from_walls_brouillar(laby,h,w,largeur,hauteur,screen,coord_joueur,2)
                else:
                    if event.key == pygame.K_SPACE:
                        gagner = True
                    elif event.key == pygame.K_a:
                        pygame.quit()
                        exit()
                    #mouvement joueur
                    act = False
                    place = move_player(event.key, x, y, w, h, largeur, hauteur, laby)
                    pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                    pygame.mixer.music.play(100, 5)
                    xtmp = x
                    ytmp = y
                    coord_joueur_tmp = (xtmp // case_w, ytmp // case_h)
                    x = place[0]
                    y = place[1]
                    laby2 = Maze(h, w, False)
                    coord_joueur = (x // case_w, y // case_h)

                    draw_laby_from_walls_brouillar(laby,h,w,largeur,hauteur,screen,coord_joueur,2)
                    screen.blit(pointeur, (x, y))
                    if coord_joueur != coord_joueur_tmp:
                        couvre(xtmp, ytmp, taille, taille, screen)
                    if not gagner and coord_joueur_tmp == coordwin:
                        screen.blit(win, (posxwin, posywin))
                    if coord_joueur == coordwin:
                        gagner = True
                    if coordcle==coord_joueur and not(possede_cle): # récupération clé
                        possede_cle = True
                        porte = pygame.mixer.music.load("musiquelaby/porte.ogg")
                        coordcle=(-15,-15)
                        pygame.mixer.music.play(1, 1)
                        afficher_elt(largeur,hauteur,'imglaby/lvl1cle.jfif',screen)
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        act=True
                    if possede_cle and act:
                        win=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/porteouverte.jpg")), (taille, taille))

                if act: # affichage suite à récupération en fonction de ce qui est visible ou non
                    screen.fill(pygame.Color('black'))
                    draw_laby_from_walls_brouillar(laby,h,w,largeur,hauteur,screen,coord_joueur,2)
                    screen.blit(pointeur, (x, y))
                    if not possede_cle and not(abs(coordcle[0]-coord_joueur[0])>2 or abs(coordcle[1]-coord_joueur[1])>2):
                        screen.blit(cle, (posxcle, posycle))
                    if not gagner and not(abs(coordwin[0]-coord_joueur[0])>2 or abs(coordwin[1]-coord_joueur[1])>2):
                        screen.blit(win, (posxwin, posywin))
                if not act : # affichage suite à déplacement en fonction de ce qui est visible ou non
                    if not possede_cle and not(abs(coordcle[0]-coord_joueur[0])>2 or abs(coordcle[1]-coord_joueur[1])>2):
                        screen.blit(cle, (posxcle, posycle))
                    if not gagner and not(abs(coordwin[0]-coord_joueur[0])>2 or abs(coordwin[1]-coord_joueur[1])>2):
                        screen.blit(win, (posxwin, posywin))
                    if not possede_cle and (abs(coordcle[0]-coord_joueur[0])>2 or abs(coordcle[1]-coord_joueur[1])>2):
                        couvre(posxcle,posycle,taille,taille,screen)
                    if not gagner and (abs(coordwin[0]-coord_joueur[0])>2 or abs(coordwin[1]-coord_joueur[1])>2):
                        couvre(posxwin,posycle,taille,taille,screen)

                pygame.display.update()
    return gagner


def jouer_invisble(largeur,hauteur,screen,w,h):
    '''lance le dernier niveau où tous les chemins sont invibles hormis la position actuelle'''
    pouv=choice_bonus(largeur,hauteur,screen,8)  # récupération pouvoir
    if pouv == 'vie':
        res=True
    else:
        res=False

    screen.fill(pygame.Color('black'))
    laby=draw_laby_start(h,w,largeur,hauteur,screen)

    time.sleep(5)

    # cacul tailles
    case_w=largeur//w
    case_h=hauteur//h

    taille = round(min(case_w*2/3,case_h*2/3))
    espacex=round((case_w-taille)*1/2)
    espacey=round((case_h-taille)*1/2)
    # chargement images
    pointeur = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
    win = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/portefermee.jpg")), (taille, taille))
    bete = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/lion.jpg")), (taille, taille))
    epee = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/épée.jpg")), (taille, taille))
    cle = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/cle.jpg")), (taille, taille))
    gagner = False
    perdu = False

    x =espacex
    y = espacey
    coord_joueur=(x//case_w,y//case_h)
    # coordonéées + affichage du poointeur du trophée et de la bete

    posxwin = largeur - espacex -taille
    posywin = hauteur - espacey -taille
    coordwin=(posxwin//case_w,posywin//case_h)

    posxbete = w//2*case_w+espacex
    posybete = h//2*case_h +espacey
    coordbete=(posxbete//case_w,posybete//case_h)
    posxepee = largeur-espacex-taille
    posyepee =espacey
    coordepee=(posxepee//case_w,posyepee//case_h)
    posxcle=espacex
    posycle=hauteur-espacey-taille
    coordcle=(posxcle//case_w,posycle//case_h)
    draw_laby_from_walls_brouillar(laby,h,w,largeur,hauteur,screen,coord_joueur,0)
    screen.blit(pointeur, (x, y))

    pygame.display.update()
    possede_epee = False
    bete_vie = True
    possede_cle = False
    reste_pouv=True
    pluiedeb = pygame.mixer.music.load("musiquelaby/pluie.ogg")
    pygame.mixer.music.play(100, 0)
    while not gagner and not perdu:
        for event in pygame.event.get():  # récupération de tous les évenements
            if event.type == pygame.QUIT:  # cas ou on ferme la fenetre
                pygame.quit()
                exit()
                gagner = True
            elif event.type == pygame.KEYDOWN:
                if event.key==pygame.K_r and reste_pouv: # activation pouvoir actif

                    if pouv=='destru':
                        act=True
                        reste_pouv=False
                        affiche_destru(largeur,hauteur,coord_joueur,laby,screen)
                        laby=destru_wall(laby,coord_joueur)
                    elif pouv=='tp':
                        act=True
                        reste_pouv=False
                        new_coord=teleportation(laby,w,h,[coordbete,coordcle,coordepee,coordwin],case_w,case_h,espacex,espacey)
                        coord_joueur=new_coord[0]
                        x=new_coord[1]
                        y=new_coord[2]
                    elif pouv=='tremblement':
                        laby=draw_laby_start(h,w,largeur,hauteur,screen)
                        act=True
                        reste_pouv=False
                    elif pouv=='vision':
                        act=True
                        reste_pouv=False
                        screen.fill(pygame.Color('black'))
                        draw_laby_from_walls(laby,h,w,largeur,hauteur,screen)
                        time.sleep(5)

                    elif pouv == 'indice':
                        reste_pouv=False
                        act=True
                        indice(laby,w,h,case_w,case_h,espacex,espacey,taille,coordcle,possede_cle,coordwin,coord_joueur,screen)

                else:
                    if event.key==pygame.K_SPACE:
                        gagner=True
                    elif event.key == pygame.K_a:
                        pygame.quit()
                        exit()

                    # mouvement joueur
                    place = move_player(event.key, x, y,w,h,largeur,hauteur,laby)
                    xtmp=x
                    ytmp=y
                    pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                    pygame.mixer.music.play(100, 5)
                    coord_joueur_tmp=(xtmp//case_w,ytmp//case_h)
                    x = place[0]
                    y = place[1]
                    coord_joueur=(x//case_w,y//case_h)
                    draw_laby_from_walls_brouillar(laby,h,w,largeur,hauteur,screen,coord_joueur,0)
                    act=False
                    screen.blit(pointeur, (x, y))

                    couvre(xtmp,ytmp,taille,taille,screen)
                    if not gagner and coord_joueur_tmp==coordwin:
                        screen.blit(win, (posxwin, posywin))


                    if bete_vie: # mouvement bete

                        place_bete = move_bete(posxbete, posybete,w,h,laby,largeur,hauteur,coordcle,coordwin,coordepee,coord_joueur)
                        x1tmp=posxbete
                        y1tmp=posybete
                        posxbete = place_bete[0]
                        posybete = place_bete[1]
                        coordbete=(posxbete//case_w,posybete//case_h)
                        coordtmp=(x1tmp//case_w,y1tmp//case_h)



                        couvre(x1tmp,y1tmp,taille,taille,screen)
                    screen.blit(pointeur, (x, y))




                    if coordepee==coord_joueur and not(possede_epee): # récupération épée
                        coordepee=(-15,-15)
                        possede_epee = True
                        ep = pygame.mixer.music.load("musiquelaby/epee.ogg")
                        pygame.mixer.music.play(1, 0)
                        afficher_elt(largeur,hauteur,'imglaby/sorsepee.webp',screen)
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        act=True

                    if coordcle==coord_joueur and not(possede_cle): # récupération clé
                        possede_cle = True
                        coordcle=(-15,-15)
                        porte = pygame.mixer.music.load("musiquelaby/porte.ogg")

                        pygame.mixer.music.play(1, 1)
                        afficher_elt(largeur,hauteur,'imglaby/lvl1cle.jfif',screen)
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        act=True
                    if possede_epee and act:
                        pointeur=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/guerrier.jpg")),(taille, taille))
                    if possede_cle and act:
                        win=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/porteouverte.jpg")), (taille, taille))

                    if coord_joueur in (coordbete,coordtmp) and coordbete in (coord_joueur,coord_joueur_tmp) and not possede_epee: # rencontre bete sans épée
                        if not res: # si pas pouvoir résurection
                            perdu = True
                            rugissement = pygame.mixer.music.load("musiquelaby/rugi.ogg")
                            pygame.mixer.music.play(1, 0)

                            afficher_elt(largeur,hauteur,'imglaby/rugissement.jfif',screen)
                            pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                            pygame.mixer.music.play(100, 5)
                        else:
                            res=False
                            afficher_elt(largeur,hauteur,'imglaby/brise.jpg',screen)
                            act=True
                            new_coord=teleportation(laby,w,h,[coordbete,coordcle,coordepee,coordwin,coord_joueur],case_w,case_h,espacex,espacey)
                            coordbete=new_coord[0]
                            posxbete=new_coord[1]
                            posybete=new_coord[2]
                    if coord_joueur in (coordbete,coordtmp) and coordbete in (coord_joueur,coord_joueur_tmp) and possede_epee and bete_vie: # rencontre bete avec épée
                        bete_vie = False
                        possede_epee=False
                        pointeur = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/bonhomme.jpg")),(taille, taille))
                        cri = pygame.mixer.music.load("musiquelaby/cri.ogg")
                        pygame.mixer.music.play(1, 0)
                        afficher_elt(largeur,hauteur,'imglaby/victorieux.jpg',screen)
                        act=True
                        pluie = pygame.mixer.music.load("musiquelaby/pluiefull.ogg")
                        pygame.mixer.music.play(100, 5)
                        posxbete=-15
                        posybete=-15
                        coordbete=(-15,-15)
                        couvre(x,y,taille,taille,screen)

                    if coord_joueur==coordwin and possede_cle:
                        gagner = True



                if act: # affichage suite à récupération ou rencontre en fonction de ce qui est visible ou non
                    screen.fill(pygame.Color('black'))
                    draw_laby_from_walls_brouillar(laby,h,w,largeur,hauteur,screen,coord_joueur,0)
                    screen.blit(pointeur, (x, y))
                    if not possede_cle and not(abs(coordcle[0]-coord_joueur[0])>1 or abs(coordcle[1]-coord_joueur[1])>1):
                        screen.blit(cle, (posxcle, posycle))
                    if bete_vie and not(abs(coordbete[0]-coord_joueur[0])>1 or abs(coordbete[1]-coord_joueur[1])>1):
                        screen.blit(bete, (posxbete, posybete))
                    if not possede_epee and not(abs(coordepee[0]-coord_joueur[0])>1 or abs(coordepee[1]-coord_joueur[1])>1) and (bete_vie ):
                        screen.blit(epee, (posxepee, posyepee))
                    if not gagner and not(abs(coordwin[0]-coord_joueur[0])>1 or abs(coordwin[1]-coord_joueur[1])>1):

                        screen.blit(win, (posxwin, posywin))
                if not act :
                    if not possede_cle and not(abs(coordcle[0]-coord_joueur[0])>1 or abs(coordcle[1]-coord_joueur[1])>1):
                        screen.blit(cle, (posxcle, posycle))
                    if not gagner and not(abs(coordwin[0]-coord_joueur[0])>1 or abs(coordwin[1]-coord_joueur[1])>1):
                        screen.blit(win, (posxwin, posywin))
                    if not possede_epee and not(abs(coordepee[0]-coord_joueur[0])>1 or abs(coordepee[1]-coord_joueur[1])>1) and (bete_vie ):
                        screen.blit(epee, (posxepee, posyepee))
                    if bete_vie and not(abs(coordbete[0]-coord_joueur[0])>1 or abs(coordbete[1]-coord_joueur[1])>1):
                        screen.blit(bete, (posxbete, posybete))
                    if not possede_cle and (abs(coordcle[0]-coord_joueur[0])>1 or abs(coordcle[1]-coord_joueur[1])>1):
                        couvre(posxcle,posycle,taille,taille,screen)
                    if not gagner and (abs(coordwin[0]-coord_joueur[0])>1 or abs(coordwin[1]-coord_joueur[1])>1):
                        couvre(posxwin,posycle,taille,taille,screen)
                    if not possede_epee and (abs(coordepee[0]-coord_joueur[0])>1 or abs(coordepee[1]-coord_joueur[1])>1):
                        couvre(posxepee, posyepee,taille,taille,screen)
                    if bete_vie and (abs(coordbete[0]-coord_joueur[0])>1 or abs(coordbete[1]-coord_joueur[1])>1):
                        couvre(posxbete, posybete,taille,taille,screen)








                pygame.display.update()

    return gagner

def move_player(depl,x,y,w,h,largeur,hauteur,laby):
    '''permet de déplacer le joueur en fonction de son déplacement et de sa position initiale retourne la nouvelle position'''
    case_w=largeur//w
    case_h=hauteur//h
    pos_act=(y//case_h,x//case_w) # position actuelle dans le labyrinthe
    depla_poss=laby.get_reachable_cells(pos_act) # cellules atteignables

    if depl == pygame.K_UP: # vers le haut
        if  (pos_act[0]-1,pos_act[1]) in depla_poss:
            y-=case_h


    elif depl == pygame.K_DOWN: # vers le bas
        if  (pos_act[0]+1,pos_act[1]) in depla_poss:
            y+=case_h


    elif depl == pygame.K_RIGHT : # vers la droite
        if  (pos_act[0],pos_act[1]+1) in depla_poss:
            x+=case_w

    elif depl == pygame.K_LEFT : # vers la gauche
        if (pos_act[0],pos_act[1]-1) in depla_poss:
            x-=case_w
    return x,y


def move_bete(x,y,w,h,laby,largeur,hauteur,coordcle,coordwin,coordepee,coord_joueur ,autre_bete=(-15,-15)):
    '''permet de modifier la position de la bete retourne les nouvelles coordonnées/ mouvement aléatoire'''
    case_w=largeur//w
    case_h=hauteur//h

    pos_act=(y//case_h,x//case_w) # position actuelle dans la labyrinthe

    depla_poss=laby.get_reachable_cells(pos_act) # cellules atteignables
    if coord_joueur != pos_act:
        if len(depla_poss)!=1:

            # suppréssion des cases importantes
            if (coordcle[1],coordcle[0]) in depla_poss:
                depla_poss.remove((coordcle[1],coordcle[0]))
            if (coordepee[1],coordepee[0]) in depla_poss:
                depla_poss.remove((coordepee[1],coordepee[0]))
            if (coordwin[1],coordwin[0]) in depla_poss:
                depla_poss.remove((coordwin[1],coordwin[0]))
            if (autre_bete[1],autre_bete[0]) in depla_poss:
                depla_poss.remove((autre_bete[1],autre_bete[0]))
        move=choice(depla_poss) # choix d'une cellule aléatoire dans les cellules atteignables

        # calcul nouvelles coordonnées
        if move[0]==pos_act[0]:
            if move[1]<pos_act[1]:
                x-=case_w
            else:
                x+=case_w
        else:
            if move[0]<pos_act[0]:
                y-=case_h
            else:
                y+=case_h





    return x,y


def move_bete_smart(x,y,w,h,espacex,espacey,laby,largeur,hauteur,coord_joueur,coordcle,coordwin,coordepee ,coordbete,autre_bete=(-15,-15)):
    '''permet de deplacer la bete en se rapprochant du joueur retourne nouvelles coordonnées'''
    case_w=largeur//w
    case_h=hauteur//h
    if coord_joueur!=coordbete:
        chemin=laby.solve_dfs((coordbete[1],coordbete[0]),(coord_joueur[1],coord_joueur[0])) # recherche du chemin entre la bete et le joueur
        if  chemin is None or len(chemin)>4:
            return move_bete(x,y,w,h,laby,largeur,hauteur,coordcle,coordwin,coordepee,coord_joueur,autre_bete)
        if len(chemin)>=2 and len(chemin)<=4: # si la distance est comprise entre 2 et 4 il se rapproche du joueur sinon déplacement aléatoire
            act=chemin[1]

        act=(act[1],act[0])
        mouve=False
        if act not in [coordcle,coordwin,coordepee,autre_bete]:
            mouve=True
        if not mouve:
            voisins=laby.get_reachable_cells(coordbete)
            for elt in[coordcle,coordwin,coordepee,autre_bete,act]:
                if elt in voisins:
                    voisins.remove(elt)
            act=choice(voisins)
        x=act[0]*case_w+espacex
        y=act[1]*case_h+espacey
    return x,y


def draw_laby_start(h,w,largeur,hauteur,screen):
    '''permet de créer et de dessiner le labyrinthe au départ'''
    draw_cote_laby(screen,largeur,hauteur) # dessine les bords
    laby=Maze.gen_fusion(h,w) # création labyrinthe
    murs=laby.get_walls() # récupération des murs
    case_w=largeur//w # récupération de la taille d'une case
    case_h=hauteur//h

    for mur in murs: # dessin de tous les murs


        start=mur[0]
        end=mur[1]
        # dessin en fonction de l'orientation du mur
        if start[0]==end[0] :

            if start[1]<end[1]:
                pos_start=(end[1]*case_w,start[0]*case_h)
                pos_end=(end[1]*case_w,case_h*(start[0]+1))
            else:
                pos_start=(start[1]*case_w,end[0]*case_h)
                pos_end=(start[1]*case_w,case_h*(end[0]+1))
        else :

            if start[0]<end[0]:
                pos_start=(end[1]*case_w,end[0]*case_h)
                pos_end=((end[1]+1)*case_w,end[0]*case_h)
            else:
                pos_start=(start[1]*case_w,start[0]*case_h)
                pos_end=((start[1]+1)*case_w,start[0]*case_h)
        draw_line(pos_start,pos_end,screen,pygame.Color('white'))
        pygame.display.update()

    return laby

def draw_line(start,end,screen,coul):
    '''permet de dessiner une ligne'''

    pygame.draw.line(screen,coul,start,end)



def draw_laby_from_walls(laby,h,w,largeur,hauteur,screen):
    '''permet de créer un laby depuis une liste de murs '''
    draw_cote_laby(screen,largeur,hauteur) # dessine bords
    murs=laby.get_walls() # récupération murs
    case_w=largeur//w
    case_h=hauteur//h
    for mur in murs: # dessin des murs
        start=mur[0]
        end=mur[1]
        # en fonction de l'orientation
        if start[0]==end[0] :

            if start[1]<end[1]:
                pos_start=(end[1]*case_w,start[0]*case_h)
                pos_end=(end[1]*case_w,case_h*(start[0]+1))
            else:
                pos_start=(start[1]*case_w,end[0]*case_h)
                pos_end=(start[1]*case_w,case_h*(end[0]+1))
        else :

            if start[0]<end[0]:
                pos_start=(end[1]*case_w,end[0]*case_h)
                pos_end=((end[1]+1)*case_w,end[0]*case_h)
            else:
                pos_start=(start[1]*case_w,start[0]*case_h)
                pos_end=((start[1]+1)*case_w,start[0]*case_h)
        draw_line(pos_start,pos_end,screen,pygame.Color('white'))
        pygame.display.update()

    return laby

def draw_laby_from_walls_brouillar(laby,h,w,largeur,hauteur,screen,coord_joueur,ecart):
    '''permet de créer un laby depuis une liste de murs et de tracer des traits noirs aux cases vides'''
    draw_cote_laby(screen,largeur,hauteur) # dessin cote
    murs=laby.get_walls() # recupération murs
    case_w=largeur//w
    case_h=hauteur//h
    for mur in murs: # efface les murs
        start=mur[0]
        end=mur[1]
        # en fonction de l'orintation
        if start[0]==end[0] :

            if start[1]<end[1]:
                pos_start=(end[1]*case_w,start[0]*case_h)
                pos_end=(end[1]*case_w,case_h*(start[0]+1))
            else:
                pos_start=(start[1]*case_w,end[0]*case_h)
                pos_end=(start[1]*case_w,case_h*(end[0]+1))
        else :

            if start[0]<end[0]:
                pos_start=(end[1]*case_w,end[0]*case_h)
                pos_end=((end[1]+1)*case_w,end[0]*case_h)
            else:
                pos_start=(start[1]*case_w,start[0]*case_h)
                pos_end=((start[1]+1)*case_w,start[0]*case_h)
        draw_line(pos_start,pos_end,screen,pygame.Color('black'))

    # dessin des murs autour du joueur
    for i in range(w):
        for j in range(h):
            if i>=coord_joueur[1]-ecart and i<=coord_joueur[1]+ecart and j>=coord_joueur[0]-ecart and j<=coord_joueur[0]+ecart: # si dans l'écart
                coord=(i,j)
                cont=laby.get_contiguous_cells(coord)

                for elt in cont:
                    if [coord,elt] in murs or [elt,coord] in murs :

                        start=coord
                        end=elt
                        if start[0]==end[0] :

                            if start[1]<end[1]:
                                pos_start=(end[1]*case_w,start[0]*case_h)
                                pos_end=(end[1]*case_w,case_h*(start[0]+1))
                            else:
                                pos_start=(start[1]*case_w,end[0]*case_h)
                                pos_end=(start[1]*case_w,case_h*(end[0]+1))
                        else :

                            if start[0]<end[0]:
                                pos_start=(end[1]*case_w,end[0]*case_h)
                                pos_end=((end[1]+1)*case_w,end[0]*case_h)
                            else:
                                pos_start=(start[1]*case_w,start[0]*case_h)
                                pos_end=((start[1]+1)*case_w,start[0]*case_h)
                        draw_line(pos_start,pos_end,screen,pygame.Color('white'))






    pygame.display.update()


    return laby
def afficher_elt(largeur,hauteur,elt,screen):
    '''permet l'affichage lors de la récupération d'un accesoire'''
    element=pygame.transform.scale(pygame.image.load(os.path.join(elt)),(largeur,hauteur)) # charge image et agrandis à la taille de l'écran
    screen.blit(element,(0,0))
    pygame.display.update()
    time.sleep(2)




def couvre(x,y,larg,haut,screen):
    '''permet de créer un carré noir pour remplacer la position précédente de l'objet'''
    carre=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/noir.png")),(larg,haut)) # carre noir taille image
    screen.blit(carre,(x,y))
    pygame.display.update()



def draw_cote_laby(screen,largeur,hauteur):
    '''Permet de dessiner les cotes du labyrinthe'''
    hauteur-=1
    largeur-=1
    draw_line((largeur,0),(largeur,hauteur),screen,pygame.Color('white')) # cote droit
    draw_line((0,0),(0,hauteur),screen,pygame.Color('white')) # cote gauche
    draw_line((0,0),(largeur,0),screen,pygame.Color('white')) # cote haut
    draw_line((0,hauteur),(largeur,hauteur),screen,pygame.Color('white')) # cote bas



def dessin_indice(x,y,larg,haut,screen):
    '''permet de créer un carré de couleur verte à l'endroit donne'''
    carre=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/position.jpg")),(larg,haut))
    screen.blit(carre,(x,y))
    pygame.display.update()

def convertion(largeur,hauteur,largeurimg,hauteurimg):
    '''permet de convertir la largeur et la longueur des images pour convenir à la fenetre'''
    pourcentage=hauteur*100//hauteurimg # calcul du pourcentage à appliquer
    largeurtmp=int(largeurimg*pourcentage/100) # application du poucentage
    hauteurfin=hauteur
    largeurfin=largeurtmp
    if largeurtmp>largeur: #si la redimention doit se faire sur la hauteur
        pourcentage=largeur*100//largeurimg
        largeurfin=largeur
        hauteurfin=int(hauteurimg*pourcentage/100)
    espace=(largeur-largeurfin)//2
    espaceh=(hauteur-hauteurfin)//2
    return largeurfin,hauteurfin,espace,espaceh
def histoire_mort(largeur,hauteur,screen,nb_laby):
    '''permet de lancer l'histoire lors de la mort du joueur'''
    mort = pygame.mixer.music.load("musiquelaby/mort.mp3")
    pygame.mixer.music.play(1, 0)
    vals=convertion(largeur,hauteur,395,572) # calcul dimention image
    largeurimg=vals[0]
    hauteurimg=vals[1]
    espace=vals[2]
    espaceh=vals[3]
    screen.fill(pygame.Color('gray'))
    bckgrd=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/mort.jfif")),(largeurimg,hauteurimg))
    screen.blit(bckgrd,(espace,espaceh))
    pygame.display.update()
    time.sleep(2)
    part=["Après s'être vaillamment battu","Et avoir affronte " + str(nb_laby )+ " lawsbyrinthes",'Notre courageux aventurier a fini par échouer ','Et nous a desormais quitté','Le secret de Lawsbyrinthe restera alors protégé',"Pour l'instant, en attendant le prochain aventurier","Les gardiens ont une fois de plus réussi leur tâche  ",'En protégeant le lawsbyrinthe au péril de leur vie']
    taille_ecrit=0
    for elt in part : # calcul taille écriture
        if len(elt)>taille_ecrit:
            taille_ecrit=len(elt)

    taille_ecrit=round(largeur*2.25//taille_ecrit)
    hist=[("Après s'être vaillamment battu",(0,0)),( "Et avoir affronte " + str(nb_laby )+ " lawsbyrinthes",(0,taille_ecrit)),('Notre courageux aventurier a fini par échouer ',(0,2*taille_ecrit)),('Et nous a desormais quitté',(0,3*taille_ecrit)),('Le secret de Lawsbyrinthe restera alors protégé ',(0,hauteur*2/3+20)),("Pour l'instant, en attandant le prochain aventurier",(0,hauteur*2/3+taille_ecrit+20)),("Les gardiens ont une fois de plus réussi leur tâche",(0,hauteur*2/3+2*taille_ecrit+20)),('En protégeant le lawsbyrinthe au péril de leur vie',(0,hauteur*2/3+3*taille_ecrit+20))]
    smallfont = pygame.font.SysFont('text',taille_ecrit)
    for elt in hist: # affichage du texte
        for event in pygame.event.get():
            if event.type ==pygame.QUIT: #cas ou on ferme la fenetre
                pygame.quit()
                exit()
            elif event.type == pygame.KEYDOWN :
                if event.key == pygame.K_a:
                    pygame.quit()
                    exit()

        text=smallfont.render(elt[0] , True , pygame.Color('white'))
        screen.blit(text , elt[1])
        pygame.display.update()
        time.sleep(2)


def affiche_destru(largeur,hauteur,position,laby,screen):
    '''lance l'affichage spécial lors de l'activation du pouvoir de destruction'''
    screen.fill(pygame.Color('black'))
    position2=(position[1],position[0])
    voisins=laby.get_reachable_cells(position2)
    conti=laby.get_contiguous_cells(position2)
    cells=[]
    for i in range(len(conti)):
        if conti[i] not in voisins:
            cells.append((conti[i][1],conti[i][0])) # ajout des cellules
    # affichage des murs présents
    if (position[0]+1,position[1]) in cells:
        draw_line((largeur*3//4,hauteur//4),(largeur*3//4,hauteur*3//4),screen,pygame.Color('white'))
    if (position[0]-1,position[1]) in cells:
        draw_line((largeur//4,hauteur//4),(largeur//4,hauteur*3//4),screen,pygame.Color('white'))
    if (position[0],position[1]+1) in cells:
        draw_line((largeur//4,hauteur*3//4),(largeur*3//4,hauteur*3//4),screen,pygame.Color('white'))
    if (position[0],position[1]-1) in cells:
        draw_line((largeur//4,hauteur//4),(largeur*3//4,hauteur//4),screen,pygame.Color('white'))
    largeurimg=largeur//4
    hauteurimg=hauteur//4
    destru=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/destruc.png")),(largeurimg,hauteurimg))
    screen.blit(destru,(largeur//2-largeurimg//2,hauteur//2-hauteurimg//2))
    pygame.display.update()
    return None


def entoure(x1,x2,y1,y2,screen,color):
    '''permet de tracer des lignes pour entourer les bonus'''
    # dessine des lignes des quatre côtés d'un objet en fonction des coordonées
    draw_line((x1,y1),(x2,y1),screen,color)
    draw_line((x1,y1),(x1,y2),screen,color)
    draw_line((x2,y1),(x2,y2),screen,color)
    draw_line((x1,y2),(x2,y2),screen,color)
    pygame.display.update()
def choice_bonus(largeur,hauteur,screen,lvl):
    '''permet de lancer le choix d un bonus en fonction du bonus'''
    jingle = pygame.mixer.music.load("musiquelaby/bonus.mp3")
    pygame.mixer.music.play(1, 2.5)
    afficher_elt(largeur,hauteur,'imglaby/magie2.jpeg',screen)
    # chargement des images
    destru = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/destruc.png")),(largeur//3, int((hauteur//2)*3/4)))
    tp = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/tp.png")),(largeur//3, int((hauteur//2)*3/4)))
    vision = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/visionnaire.png")),(largeur//3, int((hauteur//2)*3/4)))
    tremblement = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/tremblement.png")),(largeur//3, int((hauteur//2)*3/4)))
    indice = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/indice.png")),(largeur//3, int((hauteur//2)*3/4)))
    vie = pygame.transform.scale(pygame.image.load(os.path.join("imglaby/resurection.png")),(largeur//3, int((hauteur//2)*3/4)))
    choix=[(destru,'destru'),(tp,'tp'),(tremblement,'tremblement'),(indice,'indice')] # ajout pouvoir + nom associés
    if lvl in (4,5,6,8): # niveaux avec bete(s)
        choix.append((vie,'vie'))
    if lvl >=7: # niveaux avec vision réduite
        choix.append((vision,'vision'))
    # choix aléatoire de 2 bonus
    choix1=choice(choix)
    choix2=choice(choix)
    #affichage
    screen.blit(choix1[0],((largeur//3)//3,hauteur//3))
    screen.blit(choix2[0],((largeur//3)//3+largeur//3+(largeur//3)//3,hauteur//3))
    pygame.draw.rect(screen,pygame.Color('gray'),[largeur*1/2-60,hauteur-hauteur*1/8,100,35])
    smallfont = pygame.font.SysFont('bouton',35)
    text = smallfont.render('PLAY' , True , pygame.Color('white'))
    screen.blit(text , (largeur*1/2-70+20,hauteur-hauteur*1/8+10))
    taille_ec=int((largeur*2//3)*1.5//20)
    smallfont2 = pygame.font.SysFont('bouton',taille_ec)
    text2 = smallfont2.render('CHOISSISEZ UN BONUS ' , True , pygame.Color('white'))
    text3 = smallfont2.render('A USAGE UNIQUE ' , True , pygame.Color('white'))
    text4 = smallfont2.render('POUR CETTE MANCHE' , True , pygame.Color('white'))
    screen.blit(text2 , (largeur//4,15))
    screen.blit(text3 , (largeur//4,15+taille_ec))
    screen.blit(text4 , (largeur//4,15+taille_ec*2))
    pygame.display.update()
    fait=False
    res=choix1[1]
    while not fait : # tant que le joueur n'a pas fait de choix
        for event in pygame.event.get():
            if event.type ==pygame.QUIT: #cas ou on ferme la fenetre
                pygame.quit()
                exit()
            elif event.type==pygame.KEYDOWN:
                if event.key == pygame.K_a:
                    pygame.quit()
                    exit()

            elif event.type == pygame.MOUSEBUTTONDOWN: # cas ou on clic
                pos=pygame.mouse.get_pos()  # recupération position du clic
                #coordonnées des bonus
                posrecdebxc1=largeur//3//3
                posrecfinxc1=largeur//3//3+largeur//3
                posrecdebyc1=hauteur//3
                posrecfinyc1=hauteur//3+int((hauteur//2)*3/4)
                posrecdebxc2=(largeur//3)//3+largeur//3+(largeur//3)//3
                posrecfinxc2=(largeur//3)//3+largeur//3+(largeur//3)//3+largeur//3
                posrecdebyc2=hauteur//3
                posrecfinyc2=hauteur//3+int((hauteur//2)*3/4)

                posrecdebxbut=largeur*1/2-70
                posrecfinxbut=largeur*1/2-70+100
                posrecdebybut=hauteur-hauteur*1/8
                posrecfinybut=hauteur-hauteur*1/8+35
                if pos[0]>=posrecdebxc1 and pos[0]<=posrecfinxc1 and pos[1]>=posrecdebyc1 and pos[1]<=posrecfinyc1: # si pouvoir 1 selectionné

                    res=choix1[1]
                    # entoure en orange le pouvoir et en blanc l'autre pouvoir
                    entoure(posrecdebxc1,posrecfinxc1,posrecdebyc1,posrecfinyc1,screen,pygame.Color('orange'))
                    entoure(posrecdebxc1-1,posrecfinxc1+1,posrecdebyc1-1,posrecfinyc1+1,screen,pygame.Color('orange'))
                    entoure(posrecdebxc2,posrecfinxc2,posrecdebyc2,posrecfinyc2,screen,pygame.Color('white'))
                    entoure(posrecdebxc2-1,posrecfinxc2+1,posrecdebyc2-1,posrecfinyc2+1,screen,pygame.Color('white'))
                elif pos[0]>=posrecdebxc2 and pos[0]<=posrecfinxc2 and pos[1]>=posrecdebyc2 and pos[1]<=posrecfinyc2:

                    res=choix2[1]
                    # entoure en orange le pouvoir et en blanc l'autre pouvoir
                    entoure(posrecdebxc2,posrecfinxc2,posrecdebyc2,posrecfinyc2,screen,pygame.Color('orange'))
                    entoure(posrecdebxc2-1,posrecfinxc2+1,posrecdebyc2-1,posrecfinyc2+1,screen,pygame.Color('orange'))
                    entoure(posrecdebxc1,posrecfinxc1,posrecdebyc1,posrecfinyc1,screen,pygame.Color('white'))
                    entoure(posrecdebxc1-1,posrecfinxc1+1,posrecdebyc1-1,posrecfinyc1+1,screen,pygame.Color('white'))
                elif pos[0]>=posrecdebxbut and pos[0]<=posrecfinxbut and pos[1]>=posrecdebybut and pos[1]<=posrecfinybut:
                    fait=True


    return res



def destru_wall(laby,coord_joueur):
    '''execute le pouvoir de destruction'''
    choix_mur=False
    coord_joueur=(coord_joueur[1],coord_joueur[0])
    while not choix_mur:
        for event in pygame.event.get():  # récupération de tous les évenements
            if event.type == pygame.QUIT:  # cas ou on ferme la fenetre
                pygame.quit()
                exit()
                gagner = True
            elif event.type == pygame.KEYDOWN:
                if event.key == pygame.K_a:
                    pygame.quit()
                    exit()

                if event.key == pygame.K_UP: # retire le mur nord

                    laby.remove_wall(coord_joueur, (coord_joueur[0]-1,coord_joueur[1]))
                    choix_mur=True
                elif event.key == pygame.K_DOWN: # retire le mur sud

                    laby.remove_wall(coord_joueur, (coord_joueur[0]+1,coord_joueur[1]))
                    choix_mur=True
                elif event.key == pygame.K_RIGHT : # retire le mur est

                    laby.remove_wall(coord_joueur, (coord_joueur[0],coord_joueur[1]+1))
                    choix_mur=True
                elif event.key == pygame.K_LEFT : # retire le mur ouest

                    laby.remove_wall(coord_joueur, (coord_joueur[0],coord_joueur[1]-1))
                    choix_mur=True
    return laby

def teleportation(laby,w,h,retirecoord,case_w,case_h,espacex,espacey):
    '''execute le pouvoir de téléportation'''
    trouve=False
    while not trouve:
        #coordonées aléatoire
        xcoord=randint(0,w-1)
        ycoord=randint(0,h-1)
        coord=(xcoord,ycoord)
        if coord not in retirecoord: # vérification de pas tombé sur une case importante
            trouve=True
    x=xcoord*case_w+espacex # calcul de la position dans l'écran
    y=ycoord*case_h+espacey
    return coord,x,y

def indice(laby,w,h,case_w,case_h,espacex,espacey,taille,coordcle,possede_cle,coordwin,coord_joueur,screen):
    '''permet de marquer le chemin vers un objectif'''
    # calcul des coordonées dans le labyrinthe
    coord_joueur_inv=(coord_joueur[1],coord_joueur[0])
    coord_win_inv=(coordwin[1],coordwin[0])
    coordcle_inv=(coordcle[1],coordcle[0])
    i=1
    if  possede_cle: # l'objectif est d'abord la clé
        chemin=laby.solve_dfs(coord_joueur_inv,coordwin)

        while i < len(chemin) and i <= 4:
            coordtmp=(chemin[i][1],chemin[i][0])
            dessin_indice(coordtmp[0]*case_w+espacex,coordtmp[1]*case_h+espacey,taille,taille,screen)
            time.sleep(1)
            couvre(coordtmp[0]*case_w+espacex,coordtmp[1]*case_h+espacey,taille,taille,screen)
            i+=1
    else: # l'objectif devient la porte
        chemin=laby.solve_dfs(coord_joueur_inv,coordcle_inv)
        while i < len(chemin) and i <= 3:
            coordtmp=(chemin[i][1],chemin[i][0])
            dessin_indice(coordtmp[0]*case_w+espacex,coordtmp[1]*case_h+espacey,taille,taille,screen)
            time.sleep(1)
            couvre(coordtmp[0]*case_w+espacex,coordtmp[1]*case_h+espacey,taille,taille,screen)
            i+=1
    return None


def histoire_win(largeur,hauteur,screen):
    '''Permet de lancer l'histoire en cas de victoire'''
    ending = pygame.mixer.music.load("musiquelaby/ending.mp3")
    pygame.mixer.music.play(1, 0)
    afficher_elt(largeur,hauteur,'imglaby/fuite.jpg',screen)

    liste_taille=[]
    hist_tab=["Cela faisait bien des siècles","Que la Lawsdoor du dernier niveau n'avait pas été ouverte","Nombreux sont les cadavres des malheureux prédécesseurs de notre guerrier","Ainsi la richesse et les secrets qu'elle renferme vont ainsi quitter leur refuge","Mais avant cela un choix s'impose à lui "]
    for elt in hist_tab: # calcul taille écriture
        liste_taille.append(int((largeur*2.20)/len(elt)))
    taille=min(liste_taille)
    smallfont = pygame.font.SysFont('text',taille)
    haut=hauteur//3-taille
    carre=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/blanc.png")),(largeur,taille))
    for elt in hist_tab: # affichage texte
        text=smallfont.render(elt , True , pygame.Color('black'))

        screen.blit(text , (30,haut))
        pygame.display.update()

        for event in pygame.event.get():
            if event.type ==pygame.QUIT: #cas ou on ferme la fenetre
                pygame.quit()
                exit()
            if event.type==pygame.KEYDOWN:
                if event.key == pygame.K_a:
                    pygame.quit()
                    exit()

        time.sleep(3)


        screen.blit(carre,(10,haut))
        pygame.display.update()

    choix1=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/lingots.jpg")),(largeur,hauteur//2))
    choix2=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/temple.jpg")),(largeur//2,hauteur//2))
    screen.fill(pygame.Color('white'))
    screen.blit(choix1,(0,0))
    screen.blit(choix2,(largeur//2,hauteur//2))
    hist_c1=["Prendre le choix de prendre l'intégralité de l'or","Et de révéler au monde entier son succès","Engendrant une chute du Lawsbyrinthe","Et un assassinat de tous ses occupants"]
    hist_c2=["Prendre le choix de prendre en partie la réserve d'or","Garder secret le succès","Et ainsi préservé le Lawsbyrinthe et ses épreuves","Ainsi que la survie de ses occupants"]

    for elt in hist_c1: # calcul taille écriture
        liste_taille.append(int((largeur*2.20)/len(elt)))
    for elt in hist_c2: # calcul taille écriture
        liste_taille.append(int((largeur*2.20)/len(elt)))
    taille=min(liste_taille)
    smallfont = pygame.font.SysFont('text',taille)
    espace1=hauteur//2//(len(hist_c1)+1) # calcul répartition espace
    i=0
    espace2=hauteur//2//(len(hist_c2)+1) # calcul répartition espace
    j=0

    for elt in hist_c1: # affichage premier texte

        text=smallfont.render(elt , True , pygame.Color('white'))

        screen.blit(text , (30,espace1+i*espace1))
        i+=1
    for elt in hist_c2: # affichage deuxième texte
        text=smallfont.render(elt , True , pygame.Color('black'))

        screen.blit(text , (30,espace2+hauteur//2+j*espace2))
        j+=1


    pygame.display.update()

    fait=False
    while not fait :
        for event in pygame.event.get():
            if event.type ==pygame.QUIT: #cas ou on ferme la fenetre
                pygame.quit()
                exit()
            elif event.type == pygame.KEYDOWN:
                if event.key == pygame.K_a:
                    pygame.quit()
                    exit()

            elif event.type == pygame.MOUSEBUTTONDOWN: # cas ou on clic
                pos=pygame.mouse.get_pos()  # recupération position du clic
                # calcul position
                posxc1d=0
                posxc1f=largeur
                posyc1d=0
                posyc1f=hauteur//2
                posxc2d=0
                posxc2f=largeur
                posyc2d=hauteur//2
                posyc2f=hauteur
                if pos[0]>=posxc1d and pos[0]<=posxc1f and pos[1]>=posyc1d and pos[1]<=posyc1f: # choix 1
                    ending = pygame.mixer.music.load("musiquelaby/ending.mp3")
                    pygame.mixer.music.play(1, 0)
                    afficher_elt(largeur,hauteur,'imglaby/immeuble.jpg',screen)

                    hist_c1_win=["Après avoir révélé au monde entier sa victoire ","Il fonda son entreprise de voyage luxueux","L'aventurier est désormais connu dans le monde entier ","Son entreprise, prospère est numéro 1 du marché ","Le Lawsbyrinthes perdit en revanche sa réputation de site à haut risque ","Et fut transformé en musée de commémoration aux aventuriers disparus"]
                    espace1=hauteur//(len(hist_c1_win)+1)
                    for elt in hist_c1_win:
                        liste_taille.append(int((largeur*2.20)/len(elt)))
                    taille=min(liste_taille)
                    smallfont = pygame.font.SysFont('text',taille)
                    i=0
                    for elt in hist_c1_win:

                        text=smallfont.render(elt , True , pygame.Color('black'))

                        screen.blit(text , (30,espace1+i*espace1))
                        i+=1
                        pygame.display.update()
                        time.sleep(2)
                    fait=True

                elif pos[0]>=posxc2d and pos[0]<=posxc2f and pos[1]>=posyc2d and pos[1]<=posyc2f: # choix 2
                    ending = pygame.mixer.music.load("musiquelaby/ending.mp3")
                    pygame.mixer.music.play(1, 0)
                    fait = True
                    afficher_elt(largeur,hauteur,'imglaby/templenuage.png',screen)

                    hist_c2_win=["L'aventurier fit ainsi le choix noble et honorable ","Il devint mystérieusement millionaire au yeux des gens ","Mais protégea par son acte l'histoire et les mythes du lawsbyrinthes ","Et continue d'arpenter les dangereux sites que le monde réserve  ","Et invite par ailleurs tout aventurier courageux à se mesurer au Lawsbyrinthes"]
                    espace2=hauteur//(len(hist_c2_win)+1)
                    for elt in hist_c2_win:
                        liste_taille.append(int((largeur*2.20)/len(elt)))
                    taille=min(liste_taille)
                    smallfont = pygame.font.SysFont('text',taille)
                    i=0
                    for elt in hist_c2_win:

                        text=smallfont.render(elt , True , pygame.Color('black'))

                        screen.blit(text , (30,espace2+i*espace1))
                        i+=1
                        pygame.display.update()
                        time.sleep(2)

    return None



def afficher_flammes(case_w,case_h,w,h,screen,size):
    '''permet de lancer l'animation du lvl 6
    Rajoute des flammes aux intersections '''
    flamme=pygame.transform.scale(pygame.image.load(os.path.join("imglaby/flamme6.png")),(size,size))
    for i in range(1,h,2): # parcours du labyrinthe de 2 en 2
        for j in range(1,w,2):
            screen.blit(flamme,(j*case_w-(size//2),i*case_h-(size//2)))
    pygame.display.update()






main(largeur_rec,hauteur_rec)



