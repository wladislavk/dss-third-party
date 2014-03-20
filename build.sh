#!/bin/sh
#export tag_name=$1
export platform=xforty-dss
export release_tag=$platform-`date +%Y-%m-%d-%H-%M`
export release_dir=release-`date +%Y%m%d%H%M`
git tag $release_tag -m "Release tag"
echo "Created Tag $release_tag"
echo "Creating tarball $release_tag.tar.gz..."
#git tag $tag_name -m "Release tag"
git archive --format=tar $release_tag | gzip >$release_tag.temp.tar.gz
mkdir $release_dir 
tar -xzf $release_tag.temp.tar.gz -C $release_dir
rm -rf $release_tag.temp.tar.gz
#ln -fs /srv/dss/shared/q_file ./$release_dir/manage/q_file
ln -fs /srv/dss/shared/letterpdfs ./$release_dir/manage/letterpdfs
ln -fs /srv/dss/shared/edx_scripts ./$release_dir/manage/edx_scripts
ln -fs /srv/dss/shared/config/config.php ./$release_dir/manage/admin/includes/config.php
ln -fs /srv/dss/shared/config/site_config.php ./$release_dir/admin/includes/config.php
chmod 777 ./$release_dir/manage/3rdParty/tcpdf/cache
rm ./$release_dir/build.sh
tar -czf $release_tag.tar.gz ./$release_dir
echo "tar created"
rm -r ./$release_dir
#scp ./$release_dir.tar.gz dss-rh:/srv/dss/tar
#ssh dss-rh "mkdir /srv/dss/releases/$release_dir; cd /srv/dss/releases/$release_dir; tar xvfz ../../tar/$release_dir.tar.gz; ln -s /srv/dss/shared/q_file ./manage/q_file; ln -s /srv/dss/shared/config/config.php ./manage/admin/includes/config.php; ln -s /srv/dss/shared/config/site_config.php ./admin/includes/config.php" 
echo "Finished"
