FROM mysql:5.7

ENV MYSQL_ROOT_PASSWORD=rootpass
ENV MYSQL_DATABASE=sample
ENV MYSQL_USER=sampleuser
ENV MYSQL_PASSWORD=samplepass

COPY ../sql/db.sql /docker-entrypoint-initdb.d/

EXPOSE 3306