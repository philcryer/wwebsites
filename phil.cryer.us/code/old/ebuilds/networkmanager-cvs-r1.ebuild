# Copyright 1999-2004 Gentoo Foundation, Inc.
# Distributed under the terms of the GNU General Public License v2

inherit gnome2 debug eutils

DESCRIPTION="Network policy manager for the HAL-ized freedesktop.org"
HOMEPAGE="http://people.redhat.com/dcbw/NetworkManager/";
SRC_URI=""

LICENSE="GPL-2"
SLOT="0"
KEYWORDS="~x86"
IUSE="crypt debug doc"

RDEPEND=">=sys-apps/dbus-20041130 
	>=x11-libs/gtk+-2
		>=gnome-base/libglade-2
			>=gnome-base/gconf
				>=gnome-base/libgnomeui-2
					net-wireless/wireless-tools
						sys-apps/iproute2
							crypt? ( dev-libs/libgcrypt )"

							DEPEND="${RDEPEND}
								dev-util/pkgconfig
									dev-util/intltool"

									G2CONF="${G2CONF} \
									        `use_with crypt gcrypt` \
											        --disable-more-warnings \
													        --with-distro=gentoo \
															        --enable-notification-icon"

																	DOCS="AUTHORS COPYING ChangeLog INSTALL NEWS README"

																	USE_DESTDIR="1"
																	SCROLLKEEPER_UPDATE="0"

																	S=${WORKDIR}/${ECVS_MODULE}

																	inherit cvs libtool
																	ECVS_CVS_COMMAND="cvs -q -f -z4"
																	ECVS_CVS_OPTIONS="-dP"
																	ECVS_SERVER="anoncvs.gnome.org:/cvs/gnome"
																	ECVS_ANON="no"
																	ECVS_AUTH="pserver"
																	ECVS_USER="anonymous"
																	ECVS_PASS=""
																	ECVS_BRANCH="HEAD"
																	ECVS_MODULE="NetworkManager"
																	ECVS_TOP_DIR="${DISTDIR}/cvs-src/${PN}"
																	S=${WORKDIR}/${ECVS_MODULE}


																	src_unpack() {
																		cvs_src_unpack
																		}

																		src_compile() {
																			

																				 WANT_AUTOMAKE_1_6=1 PKG_CONFIG_PATH=/usr/lib/pkgconfig/ ./autogen.sh ${buildopts} \
																				 	  --host=${CHOST} \
																					  	  --sysconfdir=/etc/ \
																						  	  --prefix=/usr/ \
																							  	  --infodir=/usr/share/info \
																								  	  --mandir=/usr/share/man \
																									  	  --disable-more-warnings \
																										            --enable-more-warnings=no \
																														  --enable-debug || die "./autogen.sh failed"		

																														  	emake || die "make failed"
																															}



																															src_install() {

																																emake DESTDIR=${D} install || die "install failed"
																																}

																																pkg_postinst() {
																																	ewarn "eeek!!"
																																	}
