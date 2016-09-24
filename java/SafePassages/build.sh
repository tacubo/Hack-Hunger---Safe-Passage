JARS=jars
POSTGRESJAR=$JARS/postgresql-9.4.1211.jre6.jar

SRCPATH=src/src

CLASSPATH=$POSTGRESJAR

javac -classpath $CLASSPATH -sourcepath $SRCPATH -d out/production/src $SRCPATH/Main.java
