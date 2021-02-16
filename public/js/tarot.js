'use strict';
        //////////////////////////////////
        ////script JS Tirage de carte/////
        /////////////////////////////////
document.addEventListener('DOMContentLoaded', () => {
    
let package_card = [
    '/project-final/saint-leman/public/img/img-tarot/1-le-bateleur.jpg', 
    '/project-final/saint-leman/public/img/img-tarot/2-la-papesse.jpg',
    '/project-final/saint-leman/public/img/img-tarot/3-l-imperatrice.jpg',
    '/project-final/saint-leman/public/img/img-tarot/4-l-empereur.jpg',
    '/project-final/saint-leman/public/img/img-tarot/5-le-pape.jpg',
    '/project-final/saint-leman/public/img/img-tarot/6-l-amoureux.jpg',
    '/project-final/saint-leman/public/img/img-tarot/7-le-chariot.jpg',
    '/project-final/saint-leman/public/img/img-tarot/8-la-justice.jpg',
    '/project-final/saint-leman/public/img/img-tarot/9-l-hermite.jpg',
    '/project-final/saint-leman/public/img/img-tarot/10-la-roue-de-fortune.jpg',
    '/project-final/saint-leman/public/img/img-tarot/11-la-force.jpg',
    '/project-final/saint-leman/public/img/img-tarot/12-le-pendu.jpg',
    '/project-final/saint-leman/public/img/img-tarot/13-l-arcane-sans-nom.jpg',
    '/project-final/saint-leman/public/img/img-tarot/14-la-temperance.jpg',
    '/project-final/saint-leman/public/img/img-tarot/15-le-diable.jpg',
    '/project-final/saint-leman/public/img/img-tarot/16-la-maison-dieu.jpg',
    '/project-final/saint-leman/public/img/img-tarot/17-l-etoile.jpg',
    '/project-final/saint-leman/public/img/img-tarot/18-la-lune.jpg',
    '/project-final/saint-leman/public/img/img-tarot/19-le-soleil.jpg',
    '/project-final/saint-leman/public/img/img-tarot/20-le-jugement.jpg',
    '/project-final/saint-leman/public/img/img-tarot/21-le-monde.jpg',
    '/project-final/saint-leman/public/img/img-tarot/22-le-mat.jpg'
];



let card_text = [
    "POSITIF : C’est le début de tout. Je montre mes capacités. J’existe. Je m’affirme. Je fais des projets. J’ose entreprendre et je teste des choses nouvelles. Je suis d’un tempérament actif.J’ai un esprit jeune et dynamique. J’ai une joie de vivre. J’aime bien m’amuser.C’est une situation nouvelle qui commence et tout est encore possible. NEGATIF(carte a l'envers) : Je manque de confiance en moi. J’ai peur de m’affirmer. Je crains d’entreprendre.La nouveauté m’effraie. Je manque d’expérience. J’hésite. Je suis une touche à tout.Je commence et ne finis pas. Je me disperse. Je manque de confiance en moi.",
    "POSITIF : Je prends le temps de bien préparer mon projet. Je suis un soutien pour autrui.J’ai une autorité naturelle. Je prends ma place et me fais respecter. J’agis avec sagesse.J’ai les connaissances pour réussir. Je me prépare bien. J’inspire la confiance.Je sais bien recevoir. Je m’installe dans un lieu. J’attends un enfant.   NEGATIF(carte a l'envers) :Je me bloque et j’attends. Je me renferme sur moi-même. Je reste cachée chez moi.Je garde tout en moi sans m’exprimer. Je ne peux pas agir. Je fais du sur place.Je suis retenu par le passé. J’étouffe dans une situation.",
    "POSITIF : Je m’exprime. Je communique. J’entre en relation avec autrui.Je suis créative. J’ai des idées nouvelles et je les mets en œuvre. Je développe un projet.Je parle avec aisance et je sais bien écrire. J’ai une réflexion personnelle.Je prends des responsabilités. J’ai une belle place sociale. Je vis bien ma vie de femme.   NEGATIF(carte a l'envers) : Je parle trop. Je m’exprime trop brutalement. Je ne laisse pas l’autre s’exprimer.Je suis trop agressive et je peux avoir des paroles blessantes.Je mentalise trop les situations. Ma créativité manque de réalisme.",
    "POSITIF : J’agis. Je réalise. Je dirige. Je suis responsable d’une entreprise, d’une équipe.J’ai une place de pouvoir. Mes capacités et mon autorité sont reconnues.J’ai le sens de l’organisation. Je suis un bâtisseur. J’ai une situation stable.Je peux profiter de résultats concrets. Je m’appuie sur mon esprit logique.   NEGATIF(carte a l'envers) : Je suis trop autoritaire. Je suis trop matérialiste.  Mes idées sont butées.J’exerce un pouvoir sans nuances. Je me heurte à un pouvoir abusif.Je n’agis pas facilement. Je me sens à l’étroit dans ma situation actuelle.",
    "POSITIF : Je sais conseiller et orienter autrui. Je suis de bons conseils. Je tire les leçons des choses.Je transmets mes connaissances et je continue d’apprendre. Je suis un bon enseignant.Je développe mes propres conceptions, ma philosophie. J’ai le sens de ce qui est bien et bon.Je suis un parent impliqué, juste et bienveillant. J’ai le sens des valeurs importantes.   NEGATIF(carte a l'envers) :Je me heurte à l’autorité. Je n’écoute pas les conseils. Je n’ai pas envie d’apprendre.Je suis bloquée par des conceptions étroites et une éducation trop rigide.Je ne me sens pas légitime et soutenue dans mes choix. Je manque de bienveillance.",
    "POSITIF : Je montre mes sentiments. J’entre en contact avec autrui. J’accepte l’aide des autres. Je suis amoureuse. Je suis aimé. Je fais un choix selon mon cœur. C’est le bon choix. Je suis bien entourée. J’échange, je donne et je reçois. Je suis à égalité avec autrui. Je développe mes relations. Je vis une situation intime et agréable.   NEGATIF(carte a l'envers) : Je ne parviens pas à choisir. Je suis hésitante. Je suis tiraillée entre deux voies. Je n’ose pas dire ce que je ressens. Je me sens bloquée. J’ai peur de m’engager. J’ai des ressentiments à l’égard de certains. Je ne me sens pas aimée. J’ai de la peine.",
    "POSITIF : Je réalise mes projets. J’agis en toute indépendance. Je réussis ce que j’entreprends. Je m’affirme. Je prends mon autonomie. J’ai un esprit d’entreprise. J’avance rapidement. Je sais ce que je veux et ce que je ne veux pas. J’affirme ma façon d’être personnelle. J’ai confiance en moi et en ma dynamique. J’avance sur mon chemin de façon autonome.   NEGATIF(carte a l'envers) : Je me dirige mal. Je vais trop vite. J’agis avec précipitation. Je ne maitrise pas la situation. Je ne sais pas ce que je veux. Je fais une chose et son contraire. Je suis ambivalente. J’ai peur d’agir seul. L’indépendance me pose problème. J’ai peur de l’échec.",
    "POSITIF : Je pèse le pour et le contre et je fais un choix. Je me positionne de façon juste. Je suis rigoureuse. Je recherche l’attitude la plus équitable. Je prends une décision. Je légalise une situation. Je me mets en accord avec la loi et avec mes règles de vie. Je cherche l’harmonie et l’équilibre. Je prends le temps de me poser et d’être en paix.   NEGATIF(carte a l'envers): Je suis rigide. Je juge trop sévèrement. Je suis trop perfectionniste. Je suis bloqué et je ne parviens pas à me décider. Je rencontre un obstacle. Je ne suis pas en accord avec moi-même. Je tranche trop vite et mal.",
    "POSITIF : Je réfléchis. Je prends le temps de comprendre. Je vais au-delà des apparences. Je sais ce qui se cache derrière une situation. J’éclaircis les choses avec mon intelligence. Je fais preuve de patience. Je prends le temps nécessaire à la situation. J’agis avec prudence. Je suis capable de guider autrui et d’être une bonne thérapeute.   NEGATIF(carte a l'envers) : Je me mets à l’écart. Je m’isole et me coupe des autres. Je crains les contacts. Je me sens seul. Je souffre d’isolement. Je ne cherche pas dans la bonne direction. Je vais trop dans le détail. Je suis trop tournée sur le passé. J’avance trop lentement.",
    "POSITIF : Je m’interroge et je suis capable de répondre à mes questions. Je définis ce que je veux. Je sais ce qui me convient. J’attire la chance et les bonnes relations. Je saisis les opportunités. Je m’adapte aux événements en restant stable et en gardant une continuité. Je prends en main ma destinée. Je fais ce qu’il faut pour acquérir une prospérité.   NEGATIF(carte a l'envers) : Je tourne en rond. Je me pose trop de questions. Je mentalise et suis coupée des réalités. Je laisse les événements prendre le dessus et me dérouter. Je ne saisis pas ma chance. Je suis entrainée malgré moi sur une mauvaise voie. Je ne prends pas en main les choses.",
    "POSITIF : J’ai de l’’énergie et une grande force vitale. Je vais au bout de mon projet pour sa réussite. Je me donne un objectif et je l’atteins. Je maitrise une situation. Je suis déterminée. J’unis des forces opposées ou différentes. J’obtiens une alliance et je réconcilie les parties. Je me marie. J’obtiens ce que je veux. Je suis l’axe d’une situation. Je fais preuve de logique.   NEGATIF(carte a l'envers): Je vis un conflit. Je rencontre un obstacle majeur, une opposition interne ou externe.Je suis partagée et je ne parviens pas à tenir mes objectifs. Je lâche prise. Je me sens fragile.Je force trop les choses et me force trop moi-même. Je veux trop obtenir à tout prix.",
    "POSITIF : Je suis dans une attitude de lâcher-prise. Je n’interviens pas et j’’attends le bon moment.J’accepte le cours des choses. Je vois les choses autrement. J’assume ma voie originale.Je retourne une situation à l’avantage de chacun. J’écoute et je transmets mes intuitions.Je suis non conformiste, avec une vision différente et inspirée des choses.   NEGATIF(carte a l'envers) : Je suis bloquée et en attente. Je ne peux pas agir. Je me sens impuissante. Je suis dépendante de quelque chose. Je ne suis pas libre de mes mouvements. Je subis une perte.  Je reste indifférente à une situation. Je ne suis pas intégrée.",
    "POSITIF : Je me transforme en profondeur. Je nettoie mes vieilles idées. Je balaie mes clichés. Je change mes habitudes. Je passe à autre chose. Je tire un trait sur le passé. Je me structure et j’avance. Je me tourne vers l’avenir. J’agis rapidement. Je vis ma libido et je déblaie ce qui n’est plus utile. Je vais à l’essentiel.   NEGATIF(carte a l'envers) : Je ne sais pas tourner la page. Je n’arrive pas à me détacher du passé et des vieilles idées. Je suis trop agressive et blessante.  Je subis une agression, une blessure.Je dois faire le deuil de quelqu’un ou quelque chose. Je suis trop radicale.",
    "POSITIF : Je crée des liens. Je développe mes relations sociales. Je vis bien avec mes amis. J’échange des informations, des choses. Je suis une bonne médiatrice. Je suis diplomate. Je sais modérer mes pulsions. Je guéris. Je soigne. Je suis conciliante et sociable. Je crée une continuité. Je participe à un mouvement collectif positif. Je me sens protégée.   NEGATIF(carte a l'envers) : Je ne parviens pas à me décider. Je suis partagé entre sentiment et raison. Je suis indécise. Je me laisse entrainer par les autres. Je ne peux pas prendre position. Je ne m’impose pas. Je fais circuler de fausses nouvelles. Je suis superficielle. Je n’ai pas d’opinion personnelle.",
    "POSITIF : J’exprime et je vis mes désirs. J’écoute mon ressenti pour agir en accord avec lui. J’éclaire les choses cachées. Je révèle un secret. Je me délivre de certaines contraintes. Je tranche un conflit et me libère de ce qui m’entrave. Je comprends ce qui est souterrain. Je prends du plaisir et vis librement ma sexualité. Je m’élève au-dessus des conventions.   NEGATIF(carte a l'envers) : Je vis des sentiments de colère, de jalousie. Je romps trop vite certaines relations.Je suis excessive et je ne sais pas m’arrêter. Je suis manipulatrice ou je me fais manipulée.Je suis angoissée. J’ai une tendance à voir tout en noir.",
    "POSITIF : Je suis réaliste. Je cherche la meilleure solution. J’étudie la matière. Je suis scientifique. J’expérimente. Je suis dans une quête du vrai. Je ne crois pas aux idées reçues. J’aime le changement. Je sors des chemins battus. J’apporte un souffle d’air frais. Je vis un coup de foudre amoureux. J’ai une idée lumineuse et novatrice.   NEGATIF(carte a l'envers) : J’ai tendance à tout détruire sans distinction. Je crains ce qui peut m’arriver. J’explose facilement face aux difficultés. Je perds le sens des réalités. Je me fais des idées. Je suis trop émotive. Je me sens déstabilisée. Les changements m’effraient.",
    "POSITIF : Je donne avec naturel. Je profite de la vie. Je me repose. Je prends des vacances. Je suis tranquille et en paix. Je suis en bonne santé. Je sais soigner et apaiser autrui. Je suis douée pour les domaines artistiques. J’ai de la sensibilité et de l’intuition. Je crois en ma bonne étoile qui me guide et je la suis. Je me montre tel que je suis.   NEGATIF(carte a l'envers) : Je donne à perte sans discernement. Je ne me protège pas assez. Je m’expose trop. Je me sens vulnérable. Je suis trop candide. Je suis fataliste et trop superstitieuse. Je n’agis pas assez. Je laisse trop faire et aller les choses.",
    "POSITIF : J’imagine. Je crée. J’écoute mes rêves pour les réaliser. Je suis très intuitive. Je sais bien accueillir et écouter autrui. J’ai le sens de la famille et je suis bien entourée. Je suis une bonne financière. Je sais y faire avec l’argent. J’aime le changement. Je m’installe et je décore avec goût mes intérieurs. J’ai un sens créatif inné.   NEGATIF(carte a l'envers) : Je suis dans le flou. Je ne parviens pas à y voir clair. Je m’égare. J’ai souvent peur. Je vis des situations confuses et je ne parviens pas à en sortir. Le passé s’attache à moi. Je suis trop dépensière. Je manque d’esprit rationnel et de limites. Je souffre.",
    "POSITIF : J’ai une belle place sociale et je suis reconnue pour mes capacités. Ma position est stable. Je partage. Je donne et je reçois. Je suis heureux en couple. Je fais une bonne association. J’ai une position de pouvoir et j’assume mes responsabilités. J’ai de l’ambition. J’ai un esprit clair et rationnel qui sait fixer les limites. J’inspire le respect et la confiance.   NEGATIF(carte a l'envers) : Je dépasse mes limites et je me dépense trop. Je suis trop sèche dans mes remarques. Mon couple est mal assorti. Je vis un désamour ou une mauvaise association. J’ai une prise de conscience douloureuse. J’étouffe en restant à la même place.",
    "POSITIF : J’ai une idée nouvelle. Je me transforme et vis un renouveau. Mes vœux sont exaucés. Je m’élève. J’ai une promotion. Je vois les choses autrement et je pardonne. J’ai une intuition forte et rapide qui me guide vers une voie nouvelle. Je suis reçue. Je reçois une bonne nouvelle. J’ai une reconnaissance publique.   NEGATIF(carte a l'envers) : Je porte des jugements négatifs sur autrui et je suis l’objet de jugements négatifs. Je ne parviens pas à pardonner quelqu’un. Je reste accroché à des idées dépassées. Je me sens coupable. Je n’arrive pas à sortir de difficultés. Je ne suis pas reconnue.",
    "POSITIF : Je trouve ma place dans le monde. Je suis heureux. Je finalise mon projet. Je gère un groupe. Je crée un centre. Je suis entouré de gens valables. J’ai réussi ce que je voulais. Je reçois les lauriers de mes efforts. J’ai une position harmonieuse et reconnue. J’ai une vision globale et un esprit de synthèse.  Je suis à la maturité de ma vie.   NEGATIF(carte a l'envers) : Je ne suis pas à ma place dans le monde. Je suis trop réservé ou trop en vue. Je ne retire pas les fruits de mes efforts. Je ne suis pas reconnu à ma juste place. Je suis égocentriste. Je me protège de l’extérieur en restant dans ma bulle.",
    "POSITIF : J’avance vers l’inconnu. Je suis en route vers mon destin. Je poursuis ma voie personnelle. Je prends le risque d’aller de l’avant vers un chemin nouveau. Je voyage. Je me libère des contraintes et des exigences sociales. Je vais à ma façon originale. Je pars vers des aventures nouvelles. J’avance avec mon intuition et mon expérience.   NEGATIF(carte a l'envers) : Je ne sais pas où je vais. Je suis perdu. Je ne parviens pas à comprendre ce qui se passe. Je me trompe totalement. J’ai des idées folles en tête. Je m’égare. Je n’écoute rien. Je ne tiens pas compte de mon expérience. Je suis dans une fuite en avant."
];

let card_rotation = ["rotate(360deg) translateZ(0)", "rotate(180deg) translateZ(0)"];
    

    //recuépation des id pour le tirage de carte(bouton , carte) // 
let btn_draw = document.getElementById("draw");
let first_drawed = document.getElementById("firstdraw");
let second_drawed = document.getElementById("seconddraw");
let third_drawed = document.getElementById("thirddraw");
let first_textCard = document.getElementById('text_firstcard');
let second_textCard = document.getElementById('text_secondcard');
let third_textCard = document.getElementById('text_thirdcard');



let rotation_Length = card_rotation.length;
let randRotaFirstCard = Math.floor(Math.random() * card_rotation.length);
let firstDrawRotation = card_rotation[randRotaFirstCard];
let randRotaSecCard = Math.floor(Math.random() * rotation_Length);
let SecondDrawRotation = card_rotation[randRotaSecCard];
let randRotathirdCard = Math.floor(Math.random() * rotation_Length);
let thirdDrawRotation = card_rotation[randRotathirdCard];

let package_Length = package_card.length;
// 1er carte pioché // 
let radomcard1 = Math.floor(Math.random() * package_Length);
let textFirstDraw = card_text[radomcard1];
let carddrawed1 = package_card[radomcard1];


// 2eme carte pioché // 
let radomcard2 = Math.floor(Math.random() * package_Length);
let carddrawed2 = package_card[radomcard2];
let textSecondDraw = card_text[radomcard2];

// 3eme carte pioché // 
let radomcard3 = Math.floor(Math.random() * package_Length);
let carddrawed3 = package_card[radomcard3];
let textThirdDraw = card_text[radomcard3];

// Tirage de carte au clique  //
    btn_draw.addEventListener('click', () => {
        first_drawed.style.transition = "all 1s";
        first_drawed.style.transform = firstDrawRotation;
        first_drawed.setAttribute('src', carddrawed1);
        first_textCard.innerHTML = textFirstDraw;
        second_drawed.style.transition = "all 1s";
        second_drawed.style.transform = SecondDrawRotation;
        second_drawed.setAttribute('src', carddrawed2);
        second_textCard.innerHTML = textSecondDraw;
        third_drawed.style.transition = "all 1s";
        third_drawed.style.transform = thirdDrawRotation;
        third_drawed.setAttribute('src', carddrawed3);
        third_textCard.innerHTML = textThirdDraw;
    });
});