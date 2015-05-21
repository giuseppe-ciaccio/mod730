for i in client comune agenziaentrate agenziaterritorio ; do
    bash $i/scripts/set_up.sh clean
    bash $i/scripts/set_up.sh create all
    /bin/rm ../$i 2>/dev/null
    ln -s $PWD/$i/public ../$i
done
