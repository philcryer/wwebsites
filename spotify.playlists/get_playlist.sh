#!/bin/bash

#### Setup your environment ###################################################
## LINUX: apt install python-pip3 curl jq
## MACOS: brew install python3 curl jq
## ALL: pip3 install spotdl

#### Define playlist url ######################################################
spotify_playlist_url=https://open.spotify.com/playlist/5eROnseDtREahzRRAYSbD3

#### Run it ###################################################################
## chmod +x get_playlist.sh
## ./get_playlist.sh

set -e

spotdl --playlist ${spotify_playlist_url}
output_playlist_name=$(ls -1r|head -n1)
mv ${output_playlist_name} output_full.txt

if [ -f '${output_playlist_name}' ]; then
  rm ${output_playlist_name}
fi

while read line; do
  curl -q -s -L "${line}" | grep "Spotify.Entity" | cut -c 26- > output_line.txt
  band_name=$(cat output_line.txt | jq '.artists[].name' | cut -d"\"" -f2 | head -n1)
  song_name=$(cat output_line.txt | jq '.name' | cut -d"\"" -f2)
  echo "* ${band_name} \"${song_name}\" ($line)"
  echo "${band_name} \"${song_name}\" ($line)" >> ${output_playlist_name}
done < output_full.txt

rm output_*

exit 0
