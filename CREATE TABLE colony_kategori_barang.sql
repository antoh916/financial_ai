CREATE TABLE colony.kategori_barang (
	id_kategori INT auto_increment NOT NULL,
	nama_kategori varchar(100) NOT NULL,
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	CONSTRAINT kategori_barang_pk PRIMARY KEY (id_kategori)
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;

CREATE TABLE colony.barang (
	id_barang INT auto_increment NOT NULL,
	id_kategori INT NOT NULL,
	nama_barang varchar(100) NOT NULL,
	deskripsi text NULL,
	harga INT NOT NULL,
	gambar text NOT NULL,
	add_by INT NULL,
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	CONSTRAINT barang_pk PRIMARY KEY (id_barang)
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;

CREATE TABLE colony.cabang (
	id_cabang INT auto_increment NOT NULL,
	nama_cabang varchar(100) NOT NULL,
	CONSTRAINT Cabang_PK PRIMARY KEY (id_cabang)
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;


INSERT INTO colony.kategori_barang (nama_kategori,created_at,updated_at) VALUES
	 ('Intercom',NULL,NULL),
	 ('Camera',NULL,NULL),
	 ('Multimedia',NULL,NULL),
	 ('Sound',NULL,NULL),
	 ('Package',NULL,NULL),
	 ('Handy Talkie',NULL,NULL);

INSERT INTO colony.barang (id_kategori,nama_barang,deskripsi,harga,add_by,created_at,updated_at,gambar) VALUES
	 (2,'Intercom 2','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',50000,1,NULL,NULL,'velev-intercom-helm-bluetooth-headset-6-riders-call-ip66-1000mah-d2-6x2.jpeg'),
	 (5,'Intercom 1','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',4000000,1,NULL,NULL,'soman-helm-wireless-earphone-bluetooth-voice-control-ipx6-1000mah-y102x.jpg'),
	 (3,'Camera 1','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
',30000,1,NULL,NULL,'images.jpeg'),
	 (2,'Intercom 3','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',50000,1,NULL,NULL,'velev-intercom-helm-bluetooth-headset-6-riders-call-ip66-1000mah-d2-6x2.jpeg'),
	 (2,'Intercom 4','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',4000000,1,NULL,NULL,'soman-helm-wireless-earphone-bluetooth-voice-control-ipx6-1000mah-y102x.jpg'),
	 (2,'Intercom 5','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
',30000,1,NULL,NULL,'soman-helm-wireless-earphone-bluetooth-voice-control-ipx6-1000mah-y102x.jpg'),
	 (2,'Intercom 6','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
',30000,1,NULL,NULL,'soman-helm-wireless-earphone-bluetooth-voice-control-ipx6-1000mah-y102x.jpg'),
	 (2,'Intercom 5','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
',30000,1,NULL,NULL,'soman-helm-wireless-earphone-bluetooth-voice-control-ipx6-1000mah-y102x.jpg'),
	 (2,'Intercom 6','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
',30000,1,NULL,NULL,'soman-helm-wireless-earphone-bluetooth-voice-control-ipx6-1000mah-y102x.jpg'),
	 (3,'Camera 2','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
',30000,1,NULL,NULL,'images.jpeg');
INSERT INTO colony.barang (id_kategori,nama_barang,deskripsi,harga,add_by,created_at,updated_at,gambar) VALUES
	 (3,'Camera 3','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
',30000,1,NULL,NULL,'images.jpeg'),
	 (3,'Camera 4','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
',30000,1,NULL,NULL,'images.jpeg'),
	 (3,'Camera 5','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
',30000,1,NULL,NULL,'images.jpeg'),
	 (3,'Camera 6','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
',30000,1,NULL,NULL,'images.jpeg');


INSERT INTO colony.cabang (nama_cabang) VALUES
	 ('Bandung'),
	 ('Jakarta'),
	 ('Bali');
