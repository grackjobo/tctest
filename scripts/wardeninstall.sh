rm -rf /opt/warden/
sudo mkdir /opt/warden
sudo chown $(whoami) /opt/warden
git clone -b develop https://github.com/davidalger/warden.git /opt/warden
echo 'export PATH="/opt/warden/bin:$PATH"' >> ~/.bashrc
PATH="/opt/warden/bin:$PATH"
sudo warden svc up
