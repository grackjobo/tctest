  echo "Stop Everything"
   docker stop $(docker ps -aq)
   echo "Remove Everything"
   docker rm $(docker ps -aq)
   echo "Remove Images"
   docker rmi $(docker images -q)
   echo "Prune everything"
   docker system prune
   echo "Prune danglers"
   docker volume rm $(docker volume ls -q --filter dangling=true)