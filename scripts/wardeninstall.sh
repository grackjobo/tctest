brew install havoc-io/mutagen/mutagen
sudo rm -rf /opt/warden/
sudo mkdir /opt/warden
sudo chown $(whoami) /opt/warden
sudo git clone -b develop https://github.com/davidalger/warden.git /opt/warden
echo 'export PATH="/opt/warden/bin:$PATH"' >> ~/.bashrc
PATH="/opt/warden/bin:$PATH"
brew install wardenenv/warden/warden
sudo warden svc up
